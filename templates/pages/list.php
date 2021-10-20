<div class="list">
    <section>
        <div class="message">
            <?php if(!empty($params)): ?>
                <?php 
                switch($params['before']) {
                    case 'created':
                        echo 'Notatka została utworzona';
                        break;
                }    
                ?>
            <?php endif; ?>
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
                    <?php foreach($params['notes'] as $note): ?>
                        <tr>
                            <td><?php echo $note['id']; ?></td>
                            <td><?php echo $note['title']; ?></td>
                            <td><?php echo $note['created'];?></td>
                            <td>Opcje</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </section>
  
</div>
      