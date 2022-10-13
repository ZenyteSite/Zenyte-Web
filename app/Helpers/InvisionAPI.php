<?php

namespace App\Helpers;

class InvisionAPI
{

    private static $instance;

    private $settings;
    private $database;
    private $session;

    public function __construct()
    {
        $this->requireIPS();
        $this->refreshSession();
        $this->session = \IPS\Session::i();
        $this->database = \IPS\Db::i();
        $this->settings = \IPS\Settings::i();
    }

    /**
     * Includes the required file from the forum
     */
    private function requireIPS()
    {
        require_once config('forum.FORUM_PATH') . 'init.php';
    }

    /**
     * Refreshes our IPS session, if we ever had one.
     * Required if for some reason our session has timed out and we have yet to revisit the suite.
     */
    public function refreshSession()
    {
        \IPS\Session\Front::i();
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new InvisionAPI();
        }
        return self::$instance;
    }

    /**
     * Logs in using a given username and password.
     * @param $username
     * @param $password
     * @param bool $remember
     * @return bool
     */
    public function login($username, $password, $remember = false)
    {
        $member = null;

        try {
            $member = $this->loadMember($username);
        } catch (Exception $e) {
            return false;
        }

        if ($member == null) {
            return null;
        }

        if (!$this->verifyPassword($member->getRaw(), $password)) {
            return null;
        }

        $this->setSession($member->getRaw(), $remember);
        return $member;
    }

    /**
     * Finds a member by username
     * @param $username
     * @return null
     * @throws Exception
     */
    public function loadMember($username)
    {
        $member = \IPS\Member::load($username, 'name');
        if ($this->isGuest($member)) {
            return null;
        }
        return new InvisionMember($member);
    }

    /**
     * Checks if the user is a guest of not.
     * @param $member
     * @return bool
     */
    public function isGuest($member)
    {
        return $member->member_group_id == \IPS\Settings::i()->guest_group;
    }

    /**
     * Verifies that the password entered is correct
     * @param $member
     * @param $password
     * @return bool
     */
    public function verifyPassword($member, $password)
    {
        return password_verify($password, $member->members_pass_hash) === true;
    }

    /**
     * Sets the user session after use has been verified.
     * @param $username
     * @return null
     * @throws Exception
     */
    public function setSession($member, $rememberMe)
    {
        \IPS\Session::i()->setMember($member);

        $device = \IPS\Member\Device::loadOrCreate($member);

        $member->last_visit = $member->last_activity;
        $member->save();

        $device->anonymous = false;
        $device->updateAfterAuthentication($rememberMe, null);

        $member->memberSync('onLogin');
        $member->profileSync();
    }

    /**
     * Logs out of the current user.
     */
    public function logout()
    {
        $member = $this->getCachedMember();

        if ($member == null) {
            return; // We are already logged out
        }

        session_destroy();
        \IPS\Request::i()->clearLoginCookies();
        $member->getRaw()->memberSync('onLogout', array(\IPS\Http\Url::internal('')));
    }

    /**
     * Returns the current logged in user
     * @return null
     */
    public function getCachedMember()
    {
        \IPS\Session\Front::i(); // Refreshes our IPS session, if we ever had one.

        $member = \IPS\Member::loggedIn();

        #var_dump($this->loadMember("root"));exit;



        if ($this->isGuest($member)) {
            return null;
        }

        return new InvisionMember($member);
    }

    /**
     * Finds multi-factor authentication information of the specified type for the specified member.
     * @param $member
     * @param $type
     * @return null
     */
    public function findMfa($member, $type)
    {
        if ($member == null) {
            return null;
        }

        $mfaDetails = $member->getRaw()->get_mfa_details();

        if (count($mfaDetails) == 0) {
            return null;
        }

        $mfaToken = $mfaDetails[$type];

        if (isset($mfaToken)) {
            return $mfaToken;
        }

        return null;
    }

    /**
     * Finds and returns the latest topics in the specified board.
     * @param $board int The board to find topics in
     * @param int $maximum The maximum amount of topics to find (default 100)
     * @return array Found topics, empty array if criteria is not matched
     */
    public function findLatestTopics($board, $maximum = 100)
    {
        $select = $this->database->select("*",
            'forums_topics',
            array("approved = ? AND forum_id = ?", 1, $board),
            "start_date DESC",
            array(0, $maximum)
        );

        $topics = array();
        foreach ($select as $topic) {
            $topics[] = $topic;
        }
        return $topics;
    }

    public function getUserAwards($userId)
    {
        $selectColumns = ['awarded_title', 'awarded_reason', 'awarded_date', 'awarded_award'];
        $select = $this->database->select(
            $selectColumns,
            'awards_awarded',
            ['awarded_member = ?', $userId]
        );
        $awards = [];
        foreach ($select as $award) {
            $awards[] = [
                'icon' => $this->getAward($award['awarded_award'])['award_icon'],
                'title' => $award['awarded_title'],
                'reason' => $award['awarded_reason'],
                'date' => $award['awarded_date'],
            ];
        }
        return $awards;
    }

    public function getAward($awardId)
    {
        $selectColumns = ['award_id', 'award_icon'];
        $select = $this->database->select(
            $selectColumns,
            'awards_awards',
            ['award_id = ?', $awardId]
        );
        $awards = [];
        foreach ($select as $award) {
            $awards = $award;
        }
        return $awards;

    }

    /**
     * Finds and returns the latest posts in the specified topic.
     * @param $topic int The topic to find posts in
     * @param int $maximum The maximum amount of posts to find (default 100)
     * @return array Found posts, empty array if criteria is not matched
     */
    public function findPosts($topic, $maximum = 100)
    {
        $select = $this->database->select("*",
            'forums_posts',
            array("topic_id = ?", $topic),
            "post_date ASC",
            array(0, $maximum)
        );

        $posts = array();
        foreach ($select as $post) {
            $posts[] = $post;
        }
        return $posts;
    }

    /**
     * Gets the amount of credits for a given member id.
     * @param $member_id
     * @return array
     */
    public function getCredits($member_id)
    {
        $select = $this->database->select("field_2",
            'core_pfields_content',
            array("member_id = ?", $member_id)
        );
        return $select->first();
    }

    /**
     * Updates the amount of credits a user has.
     * @param $member_id
     * @param $amount
     * @return mixed
     */
    public function updateCredits($member_id, $amount)
    {
        $this->database->update("core_pfields_content",
            "field_2 = $amount",
            "member_id = $member_id"
        );
    }

    private function first($iterator)
    {
        foreach ($iterator as $next) return $next;
        return null;
    }
}
