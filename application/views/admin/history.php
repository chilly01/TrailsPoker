
<div class="container">
    <table class="table">
        <thread class="thread-inverse">
            <tr>
                <th>ID</th>
                <th>INFO</th>
                <th>DATE</th>
            </tr>
        </thread>
        <tbody>
<?php foreach ($history as $key=>$value){ ?>
    <tr> 
        <th scope="row"> <?= $key; ?> </th>
        <td><?= $value[0]; ?> </td>
        <td><?= $value[1]; ?> </td> 
    </tr>      
<?php } ?>  
        </tbody>
    </table>
</div>

