<div style="border: 1px solid black; padding: 20px; margin: 20px;">
    <h2><?php echo $portfolio['title']; ?></h2>
    <p><?php echo $portfolio['description']; ?></p>
    <?php foreach ($photos as $photo): ?>
        <img src="uploads/<?php echo $photo; ?>" alt="Portfolio Photo" style="width:200px;height:200px;"><br>
    <?php endforeach; ?>
</div>
