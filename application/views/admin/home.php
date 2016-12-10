<style>
    #last_action{
        color: red; 
    }
</style>
<h1>Welcome to the admin page</h1>

<span id="last_action"> <?= $update; ?></span>
</br>
<a href="<?= site_url() ?>">Main Page</a>
</br>
</br>
<a href="<?= site_url('pages/admin/update_message') ?>">Update Main Message</a>
</br>
</br>
<a href="<?= site_url('pages/admin/new_event') ?>">Add Event</a>

</br>
<div>todo: event new, event edit, logout.</div>

