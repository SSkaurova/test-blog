<?php
class CommentManager
{
    private $conn;

    public function __construct($dbConnection)
    {
        $this->conn = $dbConnection;
    }

    public function getComments()
    {
        $comments = [];
        $sql = "SELECT comment FROM comments";
        $result = $this->conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $comments[] = $row['comment'];
            }
        }

        return $comments;
    }

    public function addComment($comment)
    {
        $newComment = htmlspecialchars(trim($_POST['comment']));

        $stmt = $this->conn->prepare("INSERT INTO comments (comment) VALUES (?)");
        $stmt->bind_param("s", $newComment);
        $stmt->execute();
        $stmt->close();
    }
}