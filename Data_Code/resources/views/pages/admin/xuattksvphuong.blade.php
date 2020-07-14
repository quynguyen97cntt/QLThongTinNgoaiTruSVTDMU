<table class="table" border="1">
    <thead>
        <tr>
            <td style="font-size: 18px; font-weight: bold;" colspan="12">BẢNG THỐNG KÊ SỐ LƯỢNG SINH VIÊN THEO PHƯỜNG</td>
        </tr>
    <tr>
        <th style="font-size: 14px; font-weight: bold;">STT</th>
        <th style="font-size: 14px; font-weight: bold;" colspan="6">Tên phường</th>
        <th style="font-size: 14px; font-weight: bold;" colspan="5">Số lượng sinh viên</th>
    </tr>
    </thead>
    <tbody>
      <?php $i=1 ?>
    @foreach ($ds as $item)
    <tr>
        <td style="font-size: 13px;">{{$i++}}</td>
        <td style="font-size: 13px;" colspan="6">{{ $item->tenphuong }}</td>
        <td style="font-size: 13px;" colspan="5">{{ $item->sl }}</td>
    </tr>
    @endforeach
    <tr></tr>
    <tr>
        <?php date_default_timezone_set('Asia/Ho_Chi_Minh'); ?>
        <td style="font-size: 12px;" colspan="4">Ngày in: {{date('d/m/Y H:i:s')}}</td>
    </tr>
    </tbody>
  </table>