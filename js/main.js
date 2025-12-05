$(function(){
  // Like button click
  $(document).on('click', '.like-btn', function(e){
    e.preventDefault();
    const btn = $(this);
    const id = btn.data('id');
    btn.prop('disabled', true);
    $.post('like_idea.php', { id: id }, function(resp){
      if (resp.success) {
        // update all counters for that id
        $('.like-count[data-id="'+id+'"]').text(resp.likes);
        // small visual feedback
        btn.addClass('liked');
        btn.html('<i class="fa-solid fa-heart"></i> <span class="like-count" data-id="'+id+'">'+resp.likes+'</span>');
      } else {
        alert('Could not like. Try again.');
      }
    }, 'json').fail(function(){
      alert('Network error.');
    }).always(function(){
      setTimeout(()=>btn.prop('disabled', false), 700);
    });
  });
  // Submit comment via AJAX
  $('#comment-form').on('submit', function(e){
    e.preventDefault();
    const ideaId = $(this).data('idea');
    const commentText = $('#comment_text').val().trim();
    if (!commentText) return alert('Please write a comment.');
    $.post('add_comment.php', { idea_id: ideaId, comment_text: commentText }, function(resp){
      if (resp.success) {
        // Prepend new comment
        const c = resp.comment;
        const html = '<div class="comment-item p-2 mb-2"><div class="small text-muted">'+ new Date(c.date_posted).toLocaleString() +'</div><div>'+ $('<div>').text(c.comment_text).html().replace(/\n/g,'<br>') +'</div></div>';
        $('#comments-list').prepend(html);
        $('#comment_text').val('');
      } else {
        alert(resp.message || 'Could not post comment.');
      }
    }, 'json').fail(function(){
      alert('Network error while posting comment.');
    });});});
