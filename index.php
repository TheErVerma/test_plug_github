<?php
include "./db.php";
include "./header.php"
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<style>
    body {
        background: url('wall.webp')center no-repeat;
        background-size: cover;
        color: #fff;
    }

    span.remove_me {
        position: absolute;
        right: 10px;
        top: 0px;
        cursor: pointer;
    }

    .card {
        background: url('wood.jpg')center no-repeat;
        padding: 20px;
        margin-bottom: 20px;
        border-radius: 10px;
        background-size: cover;
        box-shadow: inset 0px 0px 30px #000, 0px 0px 80px #000;
        border: 1px solid #462813;
    }

    .title {
        padding: .375rem .75rem;
        cursor: text;
    }

    .first_name_wrapper input {
        display: none;
        background: #584632 !important;
    }

    ::-webkit-scrollbar {
        width: 0px;
    }
</style>
<header class="py-4">
    <div class="container d-flex justify-content-between align-items-center">
        <h2>
            <a href="#" class="brand text-light text-decoration-none text-uppercase ls-3">id wall</a>
        </h2>
        <button class="btn btn-primary add_card_btn">+ Add Card</button>
    </div>
</header>
<div class="container">
    <div class="card_list_wrapper">
        <div class="row mt-4 card_list_inner">
            <?php
            $entries_sql = "SELECT * FROM `entries` ORDER BY order_number ASC";
            $entries_result = mysqli_query($con, $entries_sql);
            $x = 0;
            while ($row = mysqli_fetch_array($entries_result)) {
            ?>
                <div class="col-4">
                    <div class="card text-light my_id_card position-relative animate__animated">
                        <span class="remove_me">&times;</span>
                        <input type="hidden" value="" name="order_number" id="order_number" />
                        <input type="hidden" value="<?php echo $row['u_id']; ?>" name="unique_id" id="unique_id" />
                        <div class="first_name_wrapper">
                            <div class="title" tabindex="0"><?php echo $row['fname']; ?></div>
                            <input type="text" name="fname" id="fname" class="border-0 text-light form-control" onchange="get_data(this)" value="<?php echo $row['fname']; ?>" />
                        </div>
                        <div class="first_name_wrapper">
                            <div class="title" tabindex="0"><?php echo $row['lname']; ?></div>
                            <input type="text" name="lname" id="lname" class="border-0 text-light form-control" onchange="get_data(this)" value="<?php echo $row['lname']; ?>" />
                        </div>
                    </div>
                </div>
            <?php
                $x++;
            }
            ?>
        </div>
    </div>
</div>

<script>
    $('.card_list_inner').on('click focus', '.first_name_wrapper .title', function() {
        $(this).parents(".first_name_wrapper").find("input").show();
        $(this).parents(".first_name_wrapper").find("input").select();
        $(this).hide();
    })
    $('.card_list_inner').on('focusout', '.first_name_wrapper input', function() {
        $(this).parents(".first_name_wrapper").find(".title").show();
        $(this).hide();
    })

    var number_of_cards = $('.card_list_inner .my_id_card').length;

    $(".add_card_btn").click(function() {
        const unique_id = Math.floor(Math.random() * 9999999999);
        $(".card_list_inner").prepend(`
            <div class="col-4">
                <div class="card text-light my_id_card new_card position-relative animate__animated">
                <span class="remove_me">&times;</span>
                    <input type="hidden" value="" name="order_number" id="order_number" />
                    <input type="hidden" value="` + unique_id + `" name="unique_id" id="unique_id" />
                    <div class="first_name_wrapper">
                    <div class="title" tabindex="0">First name</div>
                        <input type="text" name="fname" id="fname" class="border-0 text-light form-control" onchange="get_data(this)"/>
                    </div>
                    <div class="first_name_wrapper">
                    <div class="title" tabindex="0">Last name</div>
                        <input type="text" name="lname" id="lname" class="border-0 text-light form-control" onchange="get_data(this)"/>
                    </div>
                </div>
            </div>
        `);
        update_sorting();
    });

    function get_data(me) {
        $(me).parents(".first_name_wrapper").find(".title").html($(me).val());
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


    $('.card_list_inner').on('click', '.remove_me', function() {
        // console.log($(this).parents('.my_id_card'));

        $(this).parents('.my_id_card').addClass('animate__hinge');
        if ($(this).parents('.my_id_card').hasClass('new_card')) {
            setTimeout(function() {
                $(this).parents('.my_id_card').remove()
            }, 2000);
        } else {
            var uni_id = $(this).parents('.my_id_card').find('#unique_id').val();
            var me = $(this);
            $.ajax({
                method: "POST",
                url: "remove_card.php",
                data: {
                    unique_id: uni_id
                }
            }).done(function(data) {
                if (data == "ok_front" || data == "ok") {
                    setTimeout(function() {
                        $(this).parents('.my_id_card').remove()
                    }, 2000);
                    // me.parents('.col-4').remove();
                    number_of_cards--;
                }
            });
        }
    })

    // $('.my_id_card').click(function() {
    //     console.log($(this).find('#order_number').val());
    // })

    $(document).ready(function() {
        $('.card_list_inner').sortable({
            revert: true,
            update: function(event, ui) {
                update_sorting();
            }
        });
    })
    update_sorting();

    function update_sorting() {
        for (let i = 0; i < $('.card_list_inner .my_id_card').length; i++) {
            $($('.card_list_inner .my_id_card #order_number')[i]).val(i + 1);
            var unique_id = $($('.card_list_inner .my_id_card #unique_id')[i]).val();
            $.ajax({
                method: 'POST',
                url: 'update_order.php',
                data: {
                    order_num: i + 1,
                    unique_id: unique_id,
                }
            }).done(function(data) {
                // console.log(data);
            })
        }
    }
</script>