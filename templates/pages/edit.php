<div class="show">
    <?php $note = $params['note'] ?? null; ?>
    <?php if($note):?>
    <ul>
        <li>description: <?php echo $note['description'] ?></li>
    </ul>
    <a href="/?action=edit&id=<?php echo $note['id'] ?>"><button>Zapisz zmiany</button></a>
    <a href="/">
       <button>
         Powrót do listy notatek
       </button> 
    </a>
    <?php else: ?>
       <div>Brak notatki do wyświetlenia </div> 
    <?php endif; ?>
</div>

<div>
     <h3>Edytowanie</h3> 
    <div>
        
        <form class="note-from" action="/?action=edit" method="post">
            <ul>
                <li>
                    <label>Tytuł <span class="required">*
                    </span></label>
                    <input type="text" name="title" class="field-long"/>
                </li>
                <li>
                    <label>Treść</label>
                    <textarea name="description" id="field5" class="field-long field-textarea"></textarea>
                </li>
                <li>
                    <input type="submit" value="Submit">
                </li>
            </ul>
        </form>
    </div>
</div>