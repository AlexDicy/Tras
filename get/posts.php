<?php
class GetPosts {
    var $user;
    var $friends;
    var $homePosts;

    function __construct($user, $friends) {
        $this->user = $user;
        $this->friends = $friends;
    }

    function getPost($id) {

    }

    function getHomePosts() {
        if (is_null($this->homePosts)) {
            $fromids = empty($this->friends) ? $this->user : $this->user.", ".implode(', ', $this->friends);
            $this->homePosts = query("SELECT (SELECT Opinions.Type FROM Opinions WHERE Opinions.post = Posts.id AND Opinions.user = $this->user) AS has_opinion, (SELECT SUM(Opinions.type = 1) FROM Opinions WHERE Opinions.post = Posts.id) AS likes, (SELECT SUM(Opinions.type = 0) FROM Opinions WHERE Opinions.post = Posts.id) AS dislikes, Posts.id, Posts.user, Posts.content, Posts.date, Members.Nick, Members.verified FROM Posts JOIN Members ON Posts.user = Members.id WHERE Posts.user IN ($fromids) ORDER BY Posts.id DESC LIMIT 30");
        }
        return $this->homePosts;
    }

    function getUserPosts() {

    }
}