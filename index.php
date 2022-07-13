<?php
include "./db.php";
include "./header.php"
?>
<style>
    body {
        background: #222;
        color: #fff;
    }

    span.remove_me {
        position: absolute;
        right: 10px;
        top: 0px;
        cursor: pointer;
    }

    .card {
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
            <?php
            $entries_sql = "SELECT * FROM `entries` ORDER BY id DESC";
            $entries_result = mysqli_query($con, $entries_sql);
            while ($row = mysqli_fetch_array($entries_result)) {
            ?>
                <div class="col-4">
                    <div class="card text-light my_id_card shadow position-relative">
                        <span class="remove_me">&times;</span>
                        <input type="hidden" value="" name="order_number" />
                        <input type="hidden" value="<?php echo $row['u_id']; ?>" name="unique_id" id="unique_id" />
                        <div class="first_name_wrapper">
                            <span>First name</span>
                            <input type="text" name="fname" id="fname" class="bg-dark border-0 text-light form-control" onchange="get_data(this)" value="<?php echo $row['fname']; ?>" />
                        </div>
                        <div class="first_name_wrapper">
                            <span>Last name</span>
                            <input type="text" name="lname" id="lname" class="bg-dark border-0 text-light form-control" onchange="get_data(this)" value="<?php echo $row['lname']; ?>" />
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>

<script>
    $(".add_card_btn").click(function() {
        const unique_id = Math.floor(Math.random() * 9999999999);
        $(".card_list_inner").prepend(`
            <div class="col-4">
                <div class="card text-light my_id_card shadow position-relative">
                <span class="remove_me">&times;</span>
                    <input type="hidden" value="" name="order_number" />
                    <input type="hidden" value="` + unique_id + `" name="unique_id" id="unique_id" />
                    <div class="first_name_wrapper">
                        <span>First name</span>
                        <input type="text" name="fname" id="fname" class="bg-dark border-0 text-light form-control" onchange="get_data(this)"/>
                    </div>
                    <div class="first_name_wrapper">
                        <span>Last name</span>
                        <input type="text" name="lname" id="lname" class="bg-dark border-0 text-light form-control" onchange="get_data(this)"/>
                    </div>
                </div>
            </div>
        `);
    });

    function get_data(me) {
        var unique_id = $(me).parents('.my_id_card').find('#unique_id').val();
        var fname = $(me).parents('.my_id_card').find('#fname').val();
        var lname = $(me).parents('.my_id_card').find('#lname').val();

        if (fname != "" && lname != "") {
            // console.log(fname + " , " + lname);
            $.ajax({
                method: 'POST',
                url: 'add_card.php',
                data: {
                    unique_id: unique_id,
                    fname: fname,
                    lname: lname
                }
            }).done(function(data) {
                // console.log(data);
            })
        }
    }


    $('.remove_me').click(function(){
        var uni_id = $(this).parents('.my_id_card').find('#unique_id').val();
        var me = $(this);
        $.ajax({
            method:"POST",
            url:"remove_card.php",
            data:{
                unique_id:uni_id
            }
        }).done(function(data){
            if(data == "ok_front" || data == "ok"){
                me.parent().remove();
            }
        })
    })
</script>