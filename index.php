<?php
include "db.php";
?>
<style>
    body{
        background:#222;
    }
    .card{
        background: #111;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 10px;
    }

</style>
<div class="container">
    <button class="btn btn-primary add_card_btn">Add Card</button>
    <div class="card_list_wrapper">
        <div class="row mt-4 card_list_inner">
            <div class="col-4">
                <div class="card text-light shadow">
                    <div class="first_name_wrapper">
                        <span>First name</span>
                        <input type="text" name="fname" id="fname" class="bg-dark border-0 text-light form-control" />
                    </div>
                    <div class="first_name_wrapper">
                        <span>Last name</span>
                        <input type="text" name="lname" id="lname" class="bg-dark border-0 text-light form-control" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(".add_card_btn").click(function() {
        $(".card_list_inner").prepend(`
        <div class="col-4">
                <div class="card text-light shadow">
                    <div class="first_name_wrapper">
                        <span>First name</span>
                        <input type="text" name="fname" id="fname" class="bg-dark border-0 text-light form-control" />
                    </div>
                    <div class="first_name_wrapper">
                        <span>Last name</span>
                        <input type="text" name="lname" id="lname" class="bg-dark border-0 text-light form-control" />
                    </div>
                </div>
            </div>
        `);
    });
</script>