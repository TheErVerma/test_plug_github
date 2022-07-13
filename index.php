<?php
include "db.php";
?>
<style>
    .card_row{
        max-width: 400px;
        margin: auto;
    }
</style>
<div class="container">
    <button class="btn btn-primary">Add Card</button>
    <div class="row card_row">
        <div class="col">
            <div class="card p-2 shadow-sm rounded">
                <div class="first_name_wrapper">
                    <span>First name</span>
                    <input type="text" name="fname" id="fname" class="form-control" />
                </div>
                <div class="first_name_wrapper">
                    <span>Last name</span>
                    <input type="text" name="lname" id="lname" class="form-control" />
                </div>
            </div>
        </div>
    </div>
</div>
