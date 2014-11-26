$(function() {

    // get our Twitter feed
    $.ajax({
        url: '/twitter.php',
        dataType: 'json',
        success: function(data) {
            var output = '';
            $.each(data, function(index, tweet) {
                output += '<a href="'+tweet.url+'" class="tweet-text">'+tweet.text+'</a><br/>'+tweet.date+'<br/><br/>';
            });
            $('#tweets').html(output);
        }
    })
});