<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['username']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'mod')) {
    header("Location: index.php");
}

require '../config/db_connect.php';

// Fetch latest blog posts
if (isset($_POST['category'])) {
    $category = $_POST['category'];
    $query = "SELECT post_id, title, body, author, timestamp FROM blog_posts WHERE category = ? ORDER BY timestamp DESC LIMIT 3";
    $stmt = $db->prepare($query);
    $stmt->bind_param('s', $category);
    $stmt->execute();
    $result = $stmt->get_result();
    $posts = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    $query = "SELECT post_id, title, body, author, timestamp FROM blog_posts ORDER BY timestamp DESC LIMIT 3";
    $result = $db->query($query);
    $posts = $result->fetch_all(MYSQLI_ASSOC);
}

$query = "SELECT post_id, title, body, author, timestamp, category FROM blog_posts ORDER BY timestamp DESC LIMIT 3";
$result = $db->query($query);
$posts = $result->fetch_all(MYSQLI_ASSOC);


$query = "SELECT username, last_login, status FROM users ORDER BY last_login DESC";
$result = $db->query($query);
$users = $result->fetch_all(MYSQLI_ASSOC);

// Query to count the number of subscribed users
$query = "SELECT COUNT(*) AS subscribe_count FROM subscribers";
$result = $db->query($query);
$row = $result->fetch_assoc();
$subscribeCount = $row['subscribe_count'] ?? 0; // Assign a default value if the query fails or no subscribers found

?>


<!DOCTYPE html>
<html>
<head>
    <title>Members Club ~ Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
     <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
<div class="background-effect">
    <div class="fire"></div>
</div>

<?php include 'modules/nav.php'; ?>

<div class="notification-container">
    <div class="notification"></div>
</div>

<?php if (isset($_GET['notification'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $_GET['notification']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<div class="container mt-5">
    <div class="row">
        <div class="col-lg-12 mb-4">
            <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#createPostModal">
                Create New Post
            </button>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div id="blogSection">
                <?php foreach ($posts as $post): ?>
                    <div class="card mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title">
                                <?php
                                switch ($post['category']) {
                                    case 'website-update':
                                        echo '<i class="fas fa-info-circle"></i> Website Update';
                                        break;
                                    case 'info':
                                        echo '<i class="fas fa-info-circle"></i> Info';
                                        break;
                                    case 'critical':
                                        echo '<i class="fas fa-info-circle"></i> Critical';
                                        break;
                                    default:
                                        echo '<i class="fas fa-info-circle"></i> Unknown Category';
                                        break;
                                }
                                ?>
                            </h5>
                            <div>
                                <button class="btn btn-link edit-post" data-post-id="<?php echo $post['post_id']; ?>"
                                        data-title="<?php echo $post['title']; ?>" data-body="<?php echo $post['body']; ?>">
                                    <i class="fas fa-edit"></i> EDIT
                                </button>
                                <button class="btn btn-link delete-post" data-post-id="<?php echo $post['post_id']; ?>">
                                    <i class="fas fa-trash-alt"></i> DELETE
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <h6 class="card-subtitle mb-2 text-muted">
                                Posted by <?php echo $post['author']; ?>
                                on <?php echo $post['timestamp']; ?>
                            </h6>
                            <div class="post-content"><?php echo nl2br($post['body']); ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Last Login Users</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>USERNAME</th>
                                <th>LAST LOGIN</th>
                                <th>STATUS</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo $user['username']; ?></td>
                                    <td><?php echo $user['last_login']; ?></td>
                                    <td>
                                        <?php
                                        // Retrieve the 'status' value from the $user array
                                        $status = $user['status'];

                                        // Determine the appropriate CSS class based on the status
                                        $statusClass = ($status == 'logged-in') ? 'status-bubble connected' : 'status-bubble logged-out';
                                        $statusText = ($status == 'logged-in') ? 'Connected' : 'Disconnected';
                                        ?>
                                        <span class="<?php echo $statusClass; ?>"></span>
                                        <span class="status-text"><?php echo $statusText; ?></span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">User Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="statistics-container">
                        <div class="statistics-item">
                            <i class="fas fa-users"></i>
                            <h6>Total Registered Users</h6>
                            <p><?php echo count($users); ?></p>
                        </div>
                        <div class="statistics-item">
                            <i class="fas fa-check-circle"></i>
                            <h6>Total Subscribed Users</h6>
                            <p><?php echo $subscribeCount; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Additional Section</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">This section is reserved for future use.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="js/dashboard.js"></script>
<script src="">
        $(document).ready(function() {
        $('.dropdown-toggle').dropdown();
    });
</script>

<!-- Edit Post Modal -->
<div class="modal fade" id="editPostModal" tabindex="-1" role="dialog" aria-labelledby="editPostModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPostModalLabel">Edit Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editPostForm" method="POST" action="core/edit_post.php">
                    <input type="hidden" id="editPostId" name="post_id">
                    <div class="form-group">
                        <label for="editTitle">Title</label>
                        <input type="text" class="form-control" id="editTitle" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="editBody">Body</label>
                        <textarea class="form-control" id="editBody" name="body" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Create New Post Modal -->
<div class="modal fade" id="createPostModal" tabindex="-1" role="dialog" aria-labelledby="createPostModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPostModalLabel">Create New Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="createPostForm" method="POST" action="core/create_post.php">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="body">Body</label>
                        <textarea class="form-control" id="body" name="body" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="category">Category</label>
                        <select class="form-control" id="category" name="category">
                            <option value="website-update">Website Update</option>
                            <option value="info">Info</option>
                            <option value="critical">Critical</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for editing profile details -->
                <form id="editProfileForm" method="POST" action="edit_profile.php">
                    <!-- Add your form fields here -->
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <!-- Add more fields as needed -->

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>



<?php include 'modules/footer.php'; ?>

<!-- Notification Container -->
<div class="top-right"></div>
</body>
</html>
