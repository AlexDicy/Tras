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
                    (SELECT Opinions.Type FROM Opinions WHERE Opinions.post = root.id AND Opinions.user = $this->user)
                    AS has_opinion,
                    
                    (SELECT SUM(Opinions.type = 1) FROM Opinions WHERE Opinions.post = root.id)
                    AS likes,

                    (SELECT SUM(Opinions.type = 0) FROM Opinions WHERE Opinions.post = root.id)
                    AS dislikes,
                    
                    root.id, root.user, root.post, root.content, root.date, Members.Nick, Members.verified, Members.avatar,
                    LastReply.id AS lrid, LastReply.user AS lruser, LastReply.post AS lrpost, LastReply.content AS lrcontent, LastReply.date AS lrdate, LastReplyM.Nick AS lrmNick, LastReplyM.verified  AS lrmverified, LastReplyM.avatar  AS lrmavatar
                    
                    FROM Posts AS root
                    JOIN Members ON root.user = Members.id
                    LEFT JOIN Posts AS LastReply ON root.id = LastReply.post
                    LEFT JOIN Members AS LastReplyM ON LastReply.user = Members.id
                    
                    WHERE root.post = '$id' ORDER BY root.date DESC LIMIT $limit");
    }

    function getHomePosts() {
        if (is_null($this->homePosts)) {
            $fromids = empty($this->friends) ? $this->user : $this->user.", ".implode(', ', $this->friends);
            $this->homePosts = query("SELECT (SELECT Opinions.Type FROM Opinions WHERE Opinions.post = Posts.id AND Opinions.user = $this->user) AS has_opinion, (SELECT SUM(Opinions.type = 1) FROM Opinions WHERE Opinions.post = Posts.id) AS likes, (SELECT SUM(Opinions.type = 0) FROM Opinions WHERE Opinions.post = Posts.id) AS dislikes, Posts.id, Posts.user, Posts.content, Posts.date, Members.Nick, Members.verified FROM Posts JOIN Members ON Posts.user = Members.id WHERE Posts.user IN ($fromids) AND Posts.post = 0 ORDER BY Posts.id DESC LIMIT 30");
        }
        return $this->homePosts;
    }

    function getUserPosts($id) {
        return query("SELECT (SELECT Opinions.Type FROM Opinions WHERE Opinions.post = Posts.id AND Opinions.user = $this->user) AS has_opinion, (SELECT SUM(Opinions.type = 1) FROM Opinions WHERE Opinions.post = Posts.id) AS likes, (SELECT SUM(Opinions.type = 0) FROM Opinions WHERE Opinions.post = Posts.id) AS dislikes, Posts.id, Posts.user, Posts.content, Posts.date, Members.Nick, Members.verified FROM Posts JOIN Members ON Posts.user = Members.id WHERE Posts.user = '$id' ORDER BY Posts.id DESC LIMIT 30");
    }
}