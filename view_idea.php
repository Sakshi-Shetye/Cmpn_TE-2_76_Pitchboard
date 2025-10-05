<?php
require_once 'db_connect.php';
include 'header.php';

// Validate idea ID from GET
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    echo '<div class="alert alert-danger">Invalid idea ID.</div>';
    include 'footer.php'; exit;
}

// Fetch idea
$stmt = $conn->prepare("SELECT id, title, description, category, likes, created_at FROM ideas WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$idea = $stmt->get_result()->fetch_assoc();
if (!$idea) {
    echo '<div class="alert alert-danger">Idea not found.</div>';
    include 'footer.php'; exit;
}

// Fetch comments
$cm = $conn->prepare("SELECT comment_text, date_posted FROM comments WHERE idea_id = ? ORDER BY date_posted DESC");
$cm->bind_param('i', $id);
$cm->execute();
$comments = $cm->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<div class="row">
  <div class="col-md-8">
    <!-- Idea Card -->
    <div class="card card-glass p-4 mb-4">
      <h3><?php echo htmlspecialchars($idea['title']); ?></h3>
      <div class="mb-2 text-muted small">
        <span class="badge badge-cat"><?php echo htmlspecialchars($idea['category']); ?></span>
        <span class="ms-3"><?php echo date('M d, Y', strtotime($idea['created_at'])); ?></span>
      </div>
      <p class="lead"><?php echo nl2br(htmlspecialchars($idea['description'])); ?></p>

      <div class="d-flex justify-content-between align-items-center">
        <div>
         
          <button class="btn btn-like like-btn" data-id="<?php echo $idea['id']; ?>">
    <i class="fa-regular fa-heart"></i>
    <span class="like-count"><?php echo $idea['likes']; ?></span>
</button>

        </div>
        <div>
          <a href="index.php" class="btn btn-outline-secondary">Back to Explore</a>
        </div>
      </div>
    </div>

    <!-- Comments Section -->
    <div class="card card-glass p-3">
      <h5>Comments</h5>

      <form id="comment-form" method="POST" action="add_comment.php">
        <input type="hidden" name="idea_id" value="<?php echo $idea['id']; ?>">
        <div class="mb-2">
          <textarea name="comment_text" id="comment_text" required class="form-control form-input" rows="3" placeholder="Share feedback or encouragement..."></textarea>
        </div>
        <div class="text-end">
          <button class="btn btn-sm btn-primary">Post Comment</button>
        </div>
      </form>

      <div id="comments-list" class="mt-3">
        <?php if (empty($comments)): ?>
          <div class="text-muted small">No comments yet — be the first to encourage!</div>
        <?php else: ?>
          <?php foreach($comments as $c): ?>
            <div class="comment-item p-2 mb-2">
              <div class="small text-muted"><?php echo date('d M Y, H:i', strtotime($c['date_posted'])); ?></div>
              <div><?php echo nl2br(htmlspecialchars($c['comment_text'])); ?></div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="col-md-4">
    <!-- Idea Info -->
    <div class="card card-glass p-3 mb-3">
      <h6>About this idea</h6>
      <p class="small text-muted">Category: <strong><?php echo htmlspecialchars($idea['category']); ?></strong></p>
      <p class="small text-muted">Likes: <strong id="likes-side"><?php echo $idea['likes']; ?></strong></p>
      <p class="small text-muted">Posted: <?php echo date('M d, Y H:i', strtotime($idea['created_at'])); ?></p>
    </div>

    <!-- Trending Ideas -->
    <div class="card card-glass p-3">
      <h6>Trending Quick Picks</h6>
      <?php
        $top = $conn->prepare("SELECT id, title, likes FROM ideas ORDER BY likes DESC LIMIT 3");
        $top->execute();
        $topres = $top->get_result()->fetch_all(MYSQLI_ASSOC);
        foreach ($topres as $t) {
          echo '<div class="small mb-2"><a href="view_idea.php?id='.$t['id'].'">'.htmlspecialchars($t['title']).'</a> <span class="text-muted">('.$t['likes'].' ❤)</span></div>';
        }
      ?>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>

<script>
// ----------- COMMENTS AJAX -------------
const commentForm = document.getElementById('comment-form');
commentForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(commentForm);

    try {
        const res = await fetch('add_comment.php', { method: 'POST', body: formData });
        const data = await res.json();

        if (data.success) {
            // Format date as: 05 OCT 2025, HH:MM
            const now = new Date();
            const options = { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit' };
            const formattedDate = now.toLocaleString('en-GB', options).replace(',', '');

            // Append new comment
            const list = document.getElementById('comments-list');
            const div = document.createElement('div');
            div.className = 'comment-item p-2 mb-2';
            div.innerHTML = `
                <div class="small text-muted">${formattedDate}</div>
                <div>${data.comment.comment_text}</div>
            `;
            list.prepend(div);

            commentForm.reset();
        } else {
            alert(data.message || 'Failed to post comment');
        }
    } catch (err) {
        console.error(err);
        alert('Error posting comment');
    }
});

// ----------- LIKES AJAX -------------
document.querySelectorAll('.like-btn').forEach(btn => {
    btn.addEventListener('click', async function() {
        const ideaId = this.dataset.id;
        const formData = new FormData();
        formData.append('id', ideaId);

        try {
            const res = await fetch('like_idea.php', { method: 'POST', body: formData });
            const data = await res.json();

            if (data.success) {
                // Update button like count
                this.querySelector('.like-count').innerText = data.likes;

                // Optional: update sidebar like count
                const sidebar = document.getElementById('likes-side');
                if (sidebar) sidebar.innerText = data.likes;
            } else {
                alert('Error: ' + (data.error || 'Something went wrong'));
            }
        } catch (err) {
            console.error(err);
        }
    });
});
</script>
