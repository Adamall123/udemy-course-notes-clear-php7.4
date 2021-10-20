<div class="show">
    <?php $note = $params['note'] ?? null; ?>
    <?php if($note):?>
    <ul>
        <li>Id: <?php echo ($note['id']) ?></li>
        <li>Tytuł: <?php echo htmlentities(($note['title'])) ?></li>
        <li><?php echo htmlentities(($note['description'])) ?></li>
        <li>zapisano: <?php echo htmlentities(($note['created'])) ?></li>
    </ul>
    <?php else: ?>
       <div>Brak notatki do wyświetlenia </div> 
    <?php endif; ?>
</div>
<a href="/">
       <button>
         Powrót do listy notatek
       </button> 
    </a>