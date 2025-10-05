<?php
require_once 'db_connect.php';
include 'header.php';

// Fetch trending (top 3 by likes)
$trending_stmt = $conn->prepare("SELECT id, title, description, category, likes, created_at FROM ideas ORDER BY likes DESC, created_at DESC LIMIT 3");
$trending_stmt->execute();
$trending = $trending_stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Fetch other ideas (excluding trending IDs)
$trending_ids = array_map(function($r){ return $r['id']; }, $trending);
$placeholders = implode(',', array_fill(0, count($trending_ids ?: [0]), '?'));
if (!empty($trending_ids)) {
    $sql = "SELECT id, title, description, category, likes, created_at FROM ideas WHERE id NOT IN ($placeholders) ORDER BY created_at DESC";
    $stmt = $conn->prepare($sql);
    $types = str_repeat('i', count($trending_ids));
    $stmt->bind_param($types, ...$trending_ids);
} else {
    $stmt = $conn->prepare("SELECT id, title, description, category, likes, created_at FROM ideas ORDER BY created_at DESC");
}
$stmt->execute();
$ideas = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<?php if (!empty($_SESSION['success'])): ?>
  <div class="alert alert-success rounded-pill px-4 py-2">
    <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
  </div>
<?php endif; ?>

<!-- Trending -->
<?php if (!empty($trending)): ?>
  <div class="mb-4">
    <h5 class="section-title">🔥 Trending Ideas</h5>
    <div class="row g-3">
      <?php foreach($trending as $idea): ?>
        <div class="col-md-4">
          <div class="card card-glass h-100">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start">
                <h6 class="card-title mb-1"><?php echo htmlspecialchars($idea['title']); ?></h6>
                <span class="badge badge-cat"><?php echo htmlspecialchars($idea['category']); ?></span>
              </div>
              <p class="card-text small text-muted mb-2"><?php echo htmlspecialchars(mb_strimwidth($idea['description'], 0, 120, '...')); ?></p>
              <div class="d-flex justify-content-between align-items-center mt-3">
                <a href="view_idea.php?id=<?php echo $idea['id']; ?>" class="btn btn-sm btn-outline-primary">View</a>
                <div>
                  <button class="btn btn-like like-btn" data-id="<?php echo $idea['id']; ?>">
                    <i class="fa-regular fa-heart"></i>
                    <span class="like-count" data-id="<?php echo $idea['id']; ?>"><?php echo $idea['likes']; ?></span>
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
<?php endif; ?>

<!-- All Ideas -->
<div>
  <h5 class="section-title">All Ideas</h5>
  <div class="row g-3">
    <?php if (empty($ideas)): ?>
      <div class="col-12">
        <div class="card card-glass p-4 text-center">
          <h6>No ideas yet — be the first to pitch 🚀</h6>
          <a href="submit_idea.php" class="btn btn-pill btn-primary mt-3">+ Pitch Idea</a>
        </div>
      </div>
    <?php endif; ?>

    <?php foreach($ideas as $idea): ?>
      <div class="col-md-4">
        <div class="card card-glass h-100">
          <div class="card-body d-flex flex-column">
            <div class="d-flex justify-content-between align-items-start">
              <h6 class="card-title mb-1"><?php echo htmlspecialchars($idea['title']); ?></h6>
              <span class="badge badge-cat"><?php echo htmlspecialchars($idea['category']); ?></span>
            </div>

            <p class="card-text text-muted mb-3"><?php echo htmlspecialchars(mb_strimwidth($idea['description'], 0, 140, '...')); ?></p>

            <div class="mt-auto d-flex justify-content-between align-items-center">
              <a href="view_idea.php?id=<?php echo $idea['id']; ?>" class="btn btn-sm btn-outline-primary">View</a>
              <div>
                <button class="btn btn-like like-btn" data-id="<?php echo $idea['id']; ?>">
                  <i class="fa-regular fa-heart"></i>
                  <span class="like-count" data-id="<?php echo $idea['id']; ?>"><?php echo $idea['likes']; ?></span>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>

  </div>
</div>

<?php
include 'footer.php';
