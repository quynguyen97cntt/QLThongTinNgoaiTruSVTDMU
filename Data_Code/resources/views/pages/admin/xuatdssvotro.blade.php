<table class="table" border="1">
    <thead>
        <tr>
            <td style="font-size: 18px; font-weight: bold;" colspan="7">Thông tin chủ nhà trọ</td>
          </tr>
      @foreach ($chutro as $item)
      <tr>
          <td style="font-size: 18px;" colspan="7">Tên nhà trọ: {{ $item->tennhatro }}</td>
      </tr>
      <tr>
        <td style="font-size: 18px;" colspan="7">Tên chủ nhà trọ: {{ $item->ho }} {{ $item->ten }}</td>
      </tr>
      <tr>
        <td style="font-size: 18px;" colspan="7">Điện thoại: {{ $item->sodienthoai }}</td>
      </tr>
      <tr>
        <td style="font-size: 18px;" colspan="7">Chứng minh nhân dân: {{ $item->cmnd }}</td>
      </tr>
      <tr>
        <td style="font-size: 18px;" colspan="7">Địa chỉ: {{ $item->diachi }}</td>
      </tr>
      <tr>
        <td style="font-size: 18px;" colspan="7">Ngày đăng ký: {{ $item->ngaydangky }}</td>
      </tr>
      <tr>
        <td style="font-size: 18px;" colspan="7">Số lượng sinh viên: {{$customers->count()}} sinh viên</td>
        </tr>
    <tr>
        <td style="font-size: 18px;" colspan="7">Ngày in: {{date("Y-m-d")}}</td>
    </tr>
      @endforeach
      <tr></tr>
      <tr>
        <td style="font-size: 18px; font-weight: bold;" colspan="7">Danh sách sinh viên trọ</td>
      </tr>
    <tr>
        <th style="font-size: 14px; font-weight: bold;">STT</th>
        <th style="font-size: 14px; font-weight: bold;">MSSV</th>
        <th style="font-size: 14px; font-weight: bold;">Họ</th>
        <th style="font-size: 14px; font-weight: bold;">Tên</th>
        <th style="font-size: 14px; font-weight: bold;">Giới tính</th>
        <th style="font-size: 14px; font-weight: bold;">Ngày đến</th>
        <th style="font-size: 14px; font-weight: bold;">Phòng số</th>
    </tr>
    </thead>
    <tbody>
      <?php $i=1 ?>
    @foreach ($customers as $customer)
    <tr>
        <td style="font-size: 13px;">{{$i++}}</td>
        <td style="font-size: 13px;">{{ $customer->mssv }}</td>
        <td style="font-size: 13px;">{{ $customer->ho }}</td>
        <td style="font-size: 13px;">{{ $customer->ten }}</td>
        <td style="font-size: 13px;">{{ $customer->gioitinh }}</td>
        <td style="font-size: 13px;">{{ $customer->ngayden }}</td>
        <td style="font-size: 13px;">{{ $customer->sophong }}</td>
    </tr>
    @endforeach
    
    </tbody>
  </table>