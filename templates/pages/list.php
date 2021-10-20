<div>
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
    <?php dump($params) ?>
    <h4>lista notatek</h4> 
    <?php echo $params['resultList'] ?? ""?> 
</div>
      