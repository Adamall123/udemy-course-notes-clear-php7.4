<div>
     <h3>Edytowanie</h3> 
    <div>
    <?php if(!empty($params['note'])): ?>
       <?php $note = $params['note'] ?? null; ?>
        <form class="note-from" action="/?action=edit" method="post">
            <input name="id" type="hidden" value="<?php echo $note['id'] ?>"/>
            <ul>
                <li>
                    <label>Tytuł <span class="required">*
                    </span></label>
                    <input type="text" name="title" value="<?php echo $note['title'] ?>"class="field-long"/>
                </li>
                <li>
                    <label>Treść</label>
                    <textarea name="description" id="field5" class="field-long field-textarea"><?php echo $note['description'] ?></textarea>
                </li>
                <li>
                    <input type="submit" value="Zapisz">
                </li>
            </ul>
        </form>
        <?php else: ?>
            <div>Brak danych do wyświetlenia</div>
            <a href="/"><button>Powrót do listy notatek</button></a>
            <?php endif; ?>
    </div>
</div>