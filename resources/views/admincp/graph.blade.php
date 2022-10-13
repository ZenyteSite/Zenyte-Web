<canvas id="donateChart" width="100%" height="250px"></canvas>
<script type="text/javascript">
    var ctx = document.getElementById("donateChart").getContext('2d');
    window.chartColors = {
        red: 'rgb(255, 99, 132)',
        orange: 'rgb(255, 159, 64)',
        yellow: 'rgb(255, 205, 86)',
        green: 'rgb(75, 192, 192)',
        blue: 'rgb(54, 162, 235)',
        purple: 'rgb(153, 102, 255)',
        grey: 'rgb(201, 203, 207)'
    };
</script>
<script type="text/javascript">
    var DATASETS = [
@if($forumUser->isOwner())
        {
            label: 'Paypal',
            data: [],
            borderColor: '#4CAF50',
            backgroundColor: '#4CAF50',
            borderWidth: 1,
            lineTension: 0,
            fill: false
        },
@endif
        {
            label: 'Votes',
            data: [],
            borderColor: '#ea4335',
            backgroundColor: '#ea4335',
            borderWidth: 1,
            lineTension:0,
            fill: false
        }, {
            label: 'OSRS',
            data: [],
            borderColor: '#649abe',
            backgroundColor: '#649abe',
            borderWidth: 1,
            lineTension:0,
            fill: false
        }, {
            label: 'Crypto',
            data: [],
            borderColor: '#FFFF66',
            backgroundColor: '#FFFF66',
            borderWidth: 1,
            lineTension:0,
            fill: false
        }];