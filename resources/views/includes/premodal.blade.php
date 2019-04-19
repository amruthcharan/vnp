<!-- Modal Add Category -->
<div class="modal fade none-border" id="pre">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><strong>Prescription #1</strong></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            @php
                $prescription = \App\Prescription::find(1);
            @endphp
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="table-responsive m-t-40" style="clear: both;">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Symptoms</th>
                                </tr>
                                </thead>
                                @foreach($prescription->symptoms as $symptom)
                                    <tbody>
                                    <tr>
                                        <td class="text-left">{{$symptom->name}}</td>
                                    </tr>
                                    </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="table-responsive m-t-40" style="clear: both;">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>Diagnoses</th>
                                </tr>
                                </thead>
                                @foreach($prescription->diagnosis as $diagnosis)
                                    <tbody>
                                    <tr>
                                        <td class="text-left">{{$diagnosis->name}}</td>
                                    </tr>
                                    </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
                <div class="table-responsive m-t-40" style="clear: both;">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="text-left">Medicine</th>
                            <th>Timing</th>
                            <th class="text-right">Duration</th>
                        </tr>
                        </thead>
                        @foreach($prescription->medicinedets as $medicine)
                            <tbody>
                            <tr>
                                <td class="text-left">{{$medicine->medicine->name}}</td>
                                <td>{{$medicine->timing}}</td>
                                <td class="text-right">{{$medicine->duration}}</td>
                            </tr>
                            </tbody>
                        @endforeach
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL -->