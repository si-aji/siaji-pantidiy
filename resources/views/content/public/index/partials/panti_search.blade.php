<!-- ***** Top Feature Area Start ***** -->
<form class="fancy-top-features-area bg-gray" method="GET" action="{{ route('public.panti') }}">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="fancy-top-features-content" id="feature-pantisearch">
                    <h1 id="panti-title">Pencarian Panti</h1>

                    <div class="row no-gutters">
                        <div class="col-12 col-md-4">
                            <div class="single-top-feature">
                                <h5><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Provinsi</h5>
                                <select class="form-control select2" name="provinsi" id="field-provinsi_id" onchange="checkProvince()">
                                    <option value="all">All</option>
                                    @foreach($provinsi as $value)
                                    <option value="{{ $value->id }}">{{ $value->provinsi_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="single-top-feature">
                                <h5><i class="fa fa-clock-o" aria-hidden="true"></i> Kabupaten</h5>
                                <select class="form-control select2" name="kabupaten" id="field-kabupaten_id" onchange="checkKabupaten()" disabled>
                                    <option>All</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="single-top-feature">
                                <h5><i class="fa fa-diamond" aria-hidden="true"></i> Kecamatan</h5>
                                <select class="form-control select2" name="kecamatan" id="field-kecamatan_id" disabled>
                                    <option>All</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn" id="panti-submit">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- ***** Top Feature Area End ***** -->