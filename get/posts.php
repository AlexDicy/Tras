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
        return query("SELECT
                    (SELECT Opinions.Type FROM Opinions WHERE Opinions.post = Posts.id AND Opinions.user = $this->user)
                    AS has_opinion,
    
                    (SELECT SUM(Opinions.type = 1) FROM Opinions WHERE Opinions.post = Posts.id)
                    AS likes,
    
                    (SELECT SUM(Opinions.type = 0) FROM Opinions WHERE Opinions.post = Posts.id)
                    AS dislikes,

                    Posts.id, Posts.user, Posts.content, Posts.date, Members.Nick, Members.verified

                    FROM Posts
                    JOIN Members
                    ON Posts.user = Members.id
    
                    WHERE Posts.id = '$id'");
    }

    function getReplies($id, $limit) {
        if ($limit > 100) $limit = 100;

        return query("SELECT
                    (SELECT Opinions.Type FROM Opinions WHERE Opinions.post = Replies.id AND Opinions.user = $this->user)
                    AS has_opinion,
                    
                    (SELECT SUM(Opinions.type = 1) FROM Opinions WHERE Opinions.post = Replies.id)
                    AS likes,

                    (SELECT SUM(Opinions.type = 0) FROM Opinions WHERE Opinions.post = Replies.id)
                    AS dislikes,
                    
                    Replies.id, Replies.user, Replies.post, Replies.content, Replies.date, Members.Nick, Members.verified, Members.avatar
                    
                    FROM Replies
                    JOIN Members
                    ON Replies.user = Members.id
                    
                    WHERE Replies.post = '$id' ORDER BY Replies.date DESC LIMIT $limit");
    }

    function getHomePosts() {
        if (is_null($this->homePosts)) {
            $fromids = empty($this->friends) ? $this->user : $this->user.", ".implode(', ', $this->friends);
            $this->homePosts = query("SELECT (SELECT Opinions.Type FROM Opinions WHERE Opinions.post = Posts.id AND Opinions.user = $this->user) AS has_opinion, (SELECT SUM(Opinions.type = 1) FROM Opinions WHERE Opinions.post = Posts.id) AS likes, (SELECT SUM(Opinions.type = 0) FROM Opinions WHERE Opinions.post = Posts.id) AS dislikes, Posts.id, Posts.user, Posts.content, Posts.date, Members.Nick, Members.verified FROM Posts JOIN Members ON Posts.user = Members.id WHERE Posts.user IN ($fromids) ORDER BY Posts.id DESC LIMIT 30");
        }
        return $this->homePosts;
    }

    function getUserPosts($id) {
        return query("SELECT (SELECT Opinions.Type FROM Opinions WHERE Opinions.post = Posts.id AND Opinions.user = $this->user) AS has_opinion, (SELECT SUM(Opinions.type = 1) FROM Opinions WHERE Opinions.post = Posts.id) AS likes, (SELECT SUM(Opinions.type = 0) FROM Opinions WHERE Opinions.post = Posts.id) AS dislikes, Posts.id, Posts.user, Posts.content, Posts.date, Members.Nick, Members.verified FROM Posts JOIN Members ON Posts.user = Members.id WHERE Posts.user = '$id' ORDER BY Posts.id DESC LIMIT 30");
    }
}