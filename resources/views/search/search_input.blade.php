
<div class="search-wrapper">
    <!--<label>Ψάξε αθλητή ή αγώνα:</label>-->
    <div id="input"  style="position: relative; margin-top:10px; display: inline-block;">
      <input id="searchInput" type="text" placeholder="Ψάξε αθλητή ή αγώνα..." />
      <div id="searchPanel" class="panel" style="position: absolute; left: 0; width: 100%;">
        <ul id='resultsSearch' class="list-unstyled">
        </ul>

      </div>

    </div>
</div>


@section('scripts_end')

  <script type="text/javascript" src="/js/search/search_results_panel.js"></script>

@endsection