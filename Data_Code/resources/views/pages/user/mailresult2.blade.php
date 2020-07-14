<div class="card text-white bg-white mt-5 container">
    <div class="card-body">
        <div class="container" style="color: #000000;">
            <b>Tên nhà trọ: </b> {{$details['tennhatro']}}<br /><br />
            <b>Tên chủ nhà trọ: </h3> {{$details['name']}}<br /><br />
            <b>Điện thoại: </b> {{$details['phone']}}<br /><br />
            <b>Email: </b> {{$details['mail']}}<br /><br />
            <h3><a href="<?php echo $details['content']; ?>">Bạn vui lòng nhấp vào đây để xác thực thông tin.</a></h3>
        </div>
    </div>
</div>