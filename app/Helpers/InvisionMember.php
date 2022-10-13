<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;

class InvisionMember
{

    public $raw;
    public $id;
    public $name;
    public $password;
    public $email;
    public $mfaKey;
    public $group_id;
    public $groups;
    public $seo_name;
    public $avatar;
    public $member_posts;
    public $joined;

    public function __construct($member)
    {
        $this->raw = $member;
        $this->id = $member->member_id;
        $this->name = $member->name;
        $this->password = $member->members_pass_hash;
        $this->email = $member->email;
        $this->group_id = $member->member_group_id;
        $this->groups = $member->mgroup_others;
        $this->seo_name = $member->members_seo_name;
        $this->avatar = $member->pp_main_photo;
        $this->member_posts = $member->member_posts;
        $this->joined = $member->joined;
    }

    /**
     * @return mixed the user's id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed the users name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed the users hashed passwoed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed the users email address
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**cp
     * @return mixed the users primary group id
     */
    public function getGroupId()
    {
        return $this->group_id;
    }

    /**
     * Returns the users secondary group ids
     * @return mixed
     */
    public function getOtherGroups()
    {
        return $this->groups;
    }

    /**
     * Returns the raw IPS member object.
     * @return mixed
     */
    public function getRaw()
    {
        return $this->raw;
    }

    /**
     * Returns te SEO friendly username
     * @return mixed
     */
    public function getSeoName()
    {
        return $this->seo_name;
    }

    /**
     * Returns the amount of posts the user has.
     * @return postcount
     */
    public function getPostcount()
    {
        return $this->member_posts;
    }

    /**
     * Returns the joindate for a user
     * @return long
     */
    public function getJoined()
    {
        return $this->joined;
    }

    /**
     * Gets the profile url of the user, with seo support
     * @return string
     */
    public function getAvatarUrl()
    {
        Log::info($this->getAvatar());

        return config('forum.FORUM_ASSETS_LINK') . "/{$this->getAvatar()}";
    }

    /**
     * Returns the users avatar url.
     * @return mixed
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Gets the profile url of the user, with seo support
     * @return string
     */
    public function getProfileUrl()
    {
        if (config('forum.ENABLE_SEO')) {
            return config('forum.FORUM_LINK') . "profile/$this->id-$this->seo_name/";
        }
        //This is the exact same link so SEO support isn't really a thing here....
        return config('forum.FORUM_LINK') . "profile/$this->id-$this->seo_name/";
    }

    /**
     * Gets the content url of the user
     * @return string
     */
    public function getContentUrl()
    {
        return $this->getProfileUrl() . 'content/';
    }

    public function isAdmin()
    {
        return ($this->getRole() === "Owner" || $this->getRole() === "Admin" || $this->getRole() === "Developer" || $this->getRole() === "Manager");
    }

    public function isOwner()
    {
        return $this->getRole() === "Owner";
    }

    public function getRole()
    {
        if (in_array($this->getName(), config('forum.ranks.Owner'))) {
            return "Owner";
        }
        $groupId = $this->group_id;

        if ($groupId == 11) {
            return "Developer";
        }

        if ($groupId == 24) {
            return "Manager";
        }

        if ($groupId == 4) {
            return "Admin";
        }

        if ($groupId == 20) {
            return "Senior Moderator";
        }

        if ($groupId == 6 || $groupId == 7) {
            return "Moderator";
        }

        if ($groupId == 8) {
            return "Support";
        }

        if ($groupId == 18) {
            return "Youtuber";
        }

        return "Member";
    }

    public function isStaff()
    {
        $modGroups = array_keys(config('forum.ranks.Moderator')); //We only want the ID's
        $adminGroups =  array_keys(config('forum.ranks.Administrator'));
        $staffGroups = array_merge($modGroups, $adminGroups);
        return in_array($this->group_id, $staffGroups);
    }

}
