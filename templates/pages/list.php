<div class="list">
    <section>
        <div class="message">
            <?php if(!empty($params['before'])): ?>
                <?php 
                switch($params['before']) {
                    case 'created':
                        echo 'Notatka została utworzona';
                        break;
                    case 'edited':
                        echo 'Notatka została zaktualizowana';
                        break;
                    case 'deleted':
                        echo 'Notatka została usunięta';
                        break;
                }    
                ?>
            <?php endif; ?>
        </div>
        <div class="message">
            <?php if(!empty($params['error'])): ?>
                <?php 
                switch($params['error']) {
                    case 'missingNoteId':
                        echo 'Niepoprawny identyfikator notatki';
                        break;
                    case 'noteNotFound':
                        echo 'Notatka nie została znaleziona';
                        break;
                }    
                ?>
            <?php endif; ?>
        </div>

        <?php 
            $sort = $params['sort'] ?? [];
            $by = $sort['by'] ?? 'title';
            $order = $sort['order'] ?? 'desc';
        ?>

        <div>
            <form class="settings-form" action="/" method="GET">
            <div>
                <div>Sortuj po:</div>
                <label>tytule: <input name="sortby" type="radio" value="title" <?php echo $by === 'title' ? 'checked': '' ?>></label>
                <label>dacie: <input name="sortby" type="radio" value="created" <?php echo $by === 'created' ? 'checked': '' ?>></label>
                <div>Kierunek sortowania</div>
                <label>rosnąco: <input name="sortorder" type="radio" value="asc" <?php echo $order === 'asc' ? 'checked': '' ?>></label>
                <label>malejąco: <input name="sortorder" type="radio" value="desc"  <?php echo $order === 'desc' ? 'checked': '' ?> ></label>
            </div>
                <input type="submit" value="Wyślij"/>
            </form>
        </div>

        <div class="tbl-header">
            <table cellpadding="0" cellspacing="0" border="0">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Tytuł</th>
                        <th>Data utworzenia</th>
                        <th>Opcje</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="tbl-content">
            <table cellpadding="0" cellspacing="0" border="0">
                <tbody>
                    <?php foreach($params['notes'] ?? [] as $note): ?>
                        <tr>
                            <td><?php echo $note['id'] ?></td>
                            <td><?php echo $note['title'] ?></td>
                            <td><?php echo $note['created']?></td>
                            <td>
                                <a href="/?action=show&id=<?php echo $note['id'] ?>">
                               <button>Szczegóły</button> </a>
                               <a href="/?action=delete&id=<?php echo $note['id'] ?>">
                               <button>Usuń</button> </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </section>
  
</div>
      