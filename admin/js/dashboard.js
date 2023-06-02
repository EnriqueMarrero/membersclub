$(document).ready(function () {
    // Submit the create post form using AJAX
    $('#createPostForm').submit(function (event) {
        event.preventDefault(); // Prevent default form submission

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: 'POST',
            url: url,
            data: form.serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    // Clear the form fields
                    $('#title').val('');
                    $('#body').val('');

                    // Refresh the blog section with the updated content
                    $('#blogSection').load('core/fetch_blog_posts.php');

                    // Show success notification
                    showNotification('success', response.message);
                } else {
                    // Show error notification
                    showNotification('error', response.message);
                }
            },
            error: function (xhr, textStatus, errorThrown) {
                console.log(xhr.responseText);
            }
        });
    });

    // Delete post
    $(document).on('click', '.delete-post', function (e) {
        e.preventDefault();

        // Get the post ID from the data attribute
        var postId = $(this).data('post-id');

        // Store the reference to the current card
        var card = $(this).closest('.card');

        // Display the confirmation prompt
        if (confirm('Are you sure you want to delete this post?')) {
            // Send an AJAX request to delete the post
            $.ajax({
                url: 'core/delete_post.php',
                method: 'POST',
                data: {post_id: postId},
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        // Remove the card from the DOM
                        card.remove();

                        // Refresh the blog section with the updated content
                        $('#blogSection').load('core/fetch_blog_posts.php');

                        // Show success notification
                        showNotification('success', response.message);
                    } else {
                        // Show error notification
                        showNotification('error', response.message);
                    }
                },
                error: function (xhr, status, error) {
                    // Show error notification
                    showNotification('danger', 'An error occurred while deleting the post.');
                }
            });
        }
    });

    // Edit post
    $(document).on('click', '.edit-post', function (e) {
        e.preventDefault();

        // Get the post ID, title, and body from the data attributes
        var postId = $(this).data('post-id');
        var title = $(this).data('title');
        var body = $(this).data('body');

        // Populate the edit post modal fields with the post data
        $('#editPostId').val(postId);
        $('#editTitle').val(title);
        $('#editBody').val(body);

        // Show the edit post modal
        $('#editPostModal').modal('show');
    });

    // Submit the edit post form using AJAX
    $('#editPostForm').submit(function (event) {
        event.preventDefault(); // Prevent default form submission

        var form = $(this);
        var url = form.attr('action');

        $.ajax({
            type: 'POST',
            url: url,
            data: form.serialize(),
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    // Close the edit post modal
                    $('#editPostModal').modal('hide');

                    // Show success notification
                    showNotification('success', response.message);

                    // Refresh the blog section with the updated content
                    $('#blogSection').load('core/fetch_blog_posts.php');
                } else {
                    // Show error notification
                    showNotification('error', response.message);
                }
            },
            error: function (xhr, textStatus, errorThrown) {
                console.log(xhr.responseText);
            }
        });
    });

    function showNotification(type, message) {
        var notificationContainer = $('.notification-container');
        var notification = $('<div class="notification"></div>');

        notification.text(message);
        notification.addClass('alert-' + type);
        notificationContainer.append(notification);

        // Animate the notification
        notification.fadeIn().delay(3000).fadeOut(400, function () {
            $(this).remove();
        });
    }

    // Initialize the Bootstrap modal
    $('#editProfileModal').modal({
        show: false // Hide the modal by default
    });

    // Set the profile data in the modal when it is opened
    $('#editProfileModal').on('show.bs.modal', function (event) {
        var link = $(event.relatedTarget);
        var name = link.data('name');
        var email = link.data('email');
        $(this).find('#editName').val(name);
        $(this).find('#editEmail').val(email);
    });

    // Handle form submission using AJAX
    $('#saveChangesBtn').click(function () {
        var form = $('#editProfileForm');
        var url = form.attr('action');
        var data = form.serialize();

        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            dataType: 'json',
            success: function (response) {
                // Update the profile data in the modal
                $('#editProfileModal').find('#editName').val(response.name);
                $('#editProfileModal').find('#editEmail').val(response.email);

                // Close the modal
                $('#editProfileModal').modal('hide');
            },
            error: function (xhr, status, error) {
                console.log(xhr.responseText);
            }
        });
    });
});
