@extends('layouts.default')

@section('introduction_text')
    <p>{{ __('introduction_texts.homepage_line_1') }}</p>
    <p>{{ __('introduction_texts.homepage_line_2') }}</p>
    <p>{{ __('introduction_texts.homepage_line_3') }}</p>
@endsection

@section('content')
    <h1>top 10 lijst met meest bezochte manuals</h1>
    <ul>
        @foreach($query as $brand)
            <?php
                $manualtype = DB::table('manual_type')->where('manual_id','=',$brand->id)->get();
                $manuallist = array($manualtype);

                $type_id = $manuallist[0][0]->type_id;
                $type = DB::table('types')->where('id','=',$type_id)->get();
                $typelist = array($type);

                $brandId = $typelist[0][0]->brand_id;
                $testbrandname = DB::table('brands')->where('id','=',$brandId)->get();

                $brandname = $testbrandname[0]->name;
                $brandtype = $typelist[0][0]->name;
            ?>
            <li class="top10-list">
                <a class="button-styling" href="/">{{ $brandname }}</a> <span> : </span> <a href="/">{{ $brandtype }}</a>
            </li>
        @endforeach
    </ul>
    <h1>
        @section('title')
            {{ __('misc.all_brands') }}
        @show
    </h1>
    <?php
    $size = count($brands);
    $columns = 3;
    $chunk_size = ceil($size / $columns);
    ?>
    <div class="container">    
        <!-- Example row of columns -->
        <div class="row">

            @foreach($brands->chunk($chunk_size) as $chunk)
                <div class="col-md-4">

                    <ul>
                        @foreach($chunk as $brand)

                            <?php
                            $current_first_letter = strtoupper(substr($brand->name, 0, 1));

                            if (!isset($header_first_letter) || (isset($header_first_letter) && $current_first_letter != $header_first_letter)) {
                                echo '</ul>
						<h2>' . $current_first_letter . '</h2>
						<ul>';
                            }
                            $header_first_letter = $current_first_letter
                            ?>

                            <li>
                                <a href="/{{ $brand->id }}/{{ $brand->name_url_encoded }}/">{{ $brand->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <?php
                unset($header_first_letter);
                ?>
            @endforeach
        </div>
    </div>
@endsection
