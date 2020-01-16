<form id="panti-filter" method="GET" action="{{ route('public.panti') }}">
    <h1>Filter</h1>

    <div class="filter-body">
        <div class="form-group">
            <label for="field-keyword">Keyword</label>
            <input type="text" name="keyword" id="field-keyword" class="form-control" placeholder="Panti Name" value="{{ isset($_GET['keyword']) ? ($_GET['keyword'] ?? '') : '' }}">
        </div>

        <div class="form-group">
            <label for="field-provinsi_id">Provinsi</label>
            <select class="form-control select2" name="provinsi" id="field-provinsi_id" onchange="checkProvince()">
                <option value="all">All</option>
                @foreach($provinsi as $value)
                <option value="{{ $value->id }}" {{ isset($_GET['provinsi']) ? ($_GET['provinsi'] == $value->id ? 'selected' : '') : '' }}>{{ $value->provinsi_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="field-kabupaten_id">Kabupaten</label>
            <select class="form-control select2" name="kabupaten" id="field-kabupaten_id" onchange="checkKabupaten()" disabled>
                <option value="all">All</option>
            </select>
        </div>

        <div class="form-group">
            <label for="field-kecamatan_id">Kecamatan</label>
            <select class="form-control select2" name="kecamatan" id="field-kecamatan_id" disabled>
                <option>All</option>
            </select>
        </div>

        <div class="form-group row">
            <div class="offset-sm-2 col-sm-10 text-right text-md-right">
                <button type="submit" id="panti-submit" class="btn btn-sm fancy-btn fancy-dark">Submit</button>
            </div>
        </div>
    </div>
</form>