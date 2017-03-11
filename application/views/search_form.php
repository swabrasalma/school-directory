<form class="form-horizontal" action="search" method="POST" role="form">
    <div class="form-group">
      <label for="inputType" class="col-md-2 control-label">Search</label>
      <div class="col-md-8">
          <input type="text" class="form-control" id="inputType" name="search_value" placeholder="Type">
      </div>
    </div>
    <div class="form-group">
        <span class="col-md-2 control-label">Search By</span>
        <div class="col-md-6">
            <div class="form-group row">
                <div class="col-md-6">
                    <select class="form-control" name="search_type">
					  <option value="1">School</option>
					  <option value="2">Student</option>
					</select>
                </div>
                <div class="col-md-2">
                    <input type="submit" class="btn btn-primary" id="inputValue" placeholder="Value" value="Search">
                </div>
            </div>
        </div>
    </div>
</form>