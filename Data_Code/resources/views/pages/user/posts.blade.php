@extends('layouts.master')

@section('master')
<div class="bg-image-post">
    <div class="card-body">
        <div class="container">
            <div class="row mt-2 mb-4">
            @foreach($dsBaiViet as $item)
                <div class="col-md-12 m-top-ward mb-4">
                    <div class="card">
                        <div class="card-body bg-opacity">

                            <div class="row">
                                <div class="ml-3">
                                    <?php $dem=0;
                                    $str="";
                                     ?>
                                    @foreach($anhbaiviet as $imgbaiviet)
                                        @if($imgbaiviet->mabaiviet==$item->id)
                                            <?php 
                                            $dem=1;
                                            $str = $imgbaiviet->name;
                                            ?>
                                            @break
                                        @endif
                                    @endforeach
                                    @if($dem==1)
                                        <a href="{{ route('chitietthongbao',['id' => $item->id])}}"><img src="images/{{$str}}" width="150" height="150" ></a>
                                    @else
                                    <a href="{{ route('chitietthongbao',['id' => $item->id])}}"><img src="images/noimage.png" width="150" height="150" ></a>   
                                    @endif
                                </div>
                                <div class="ml-3">
                                <p ><a href="{{ route('chitietbaiviet',['id' => $item->id])}}"><h5 class="ml-3" style="color: #007bff;">{{$item->tieude}}</h5></a></p>
                                <p class="ml-3"><i class="fas fa-map-marker-alt"></i> {{$item->tenpx}}, Thủ Dầu Một, Bình Dương</p>
                                   <div class="row mb-2">
                                        <div class="col-md-5 col-sm-12 ml-3"> @if($item->giaphong === null) <b style="color: green;">Thoả thuận</b> @else <b style="color: green;">{{number_format($item->giaphong)}} /tháng</b> @endif</div>
                                        <div class="col-md-6 col-sm-12 ml-3">Ngày đăng: {{date("d/m/Y", strtotime($item->ngaytao))}}</div>
                                   </div> 
                                    <div class="ml-3 mr-2 text-justify">
                                        <?php
                                            $str = $item->noidung;
                                            $str = strip_tags($str);
                                            if(strlen($str)>100) 
                                            {
                                                $strCut = substr($str, 0, 100);
                                                $str = substr($strCut, 0, strrpos($strCut, ' ')).'...';
                                                echo $str;
                                            }
                                            else 
                                            {
                                                echo $str;
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>

            <!-- Pagination -->
            <div class="row justify-content-end">
                {{ $dsBaiViet->links() }}
            </div>

        </div>
    </div>
</div>
@endsection
