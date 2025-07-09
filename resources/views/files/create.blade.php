@extends('layouts.app')

@section('title', 'Upload File')

@section('content')
<div class="container mt-5 create-container">
    <div class="card bg-dark text-white">
        <div class="card-body">
            <h4 class="mb-4" style="font-size: 16px;">Upload a File</h4>
            <form method="POST" action="{{ route('files.send') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="type" class="form-label">Document Type</label>
                    <select class="form-control" id="type" name="type" required>
                        <option value="" disabled selected>Select Document Type</option>
                        <option>2023 Procurement</option>
                        <option>2024 Procurement</option>
                        <option>Access Pass</option>
                        <option>Accounts Payable</option>
                        <option>Admin Internal Doc</option>
                        <option>AOM COA</option>
                        <option>BP 202 Form</option>
                        <option>BTR Certification</option>
                        <option>Change Order</option>
                        
                        <option>CIC</option>
                        <option>CIDOS</option>
                        <option>CIIMD</option>
                        <option>CMT Docs</option>
                        <option>COC-FAC</option>
                        <option>Contract Renewal</option>
                        <option>Contract Termination</option>
                        <option>Contract Termination 2022</option>
                        <option>CSR</option>
                        <option>CTC DOCUMENTS</option>
                        <option>Discontinuance 2023</option>
                        <option>Download of Funds to ROs</option>
                        <option>DV / FUND TRANSFER</option>
                        <option>DV / ORS / FUND TRANSFER</option>
                        <option>DV / ORS / SARO</option>
                        <option>End of Sevice</option>
                        <option>Endorsement</option>
                        <option>Endorsement/Request letter</option>
                        <option>FAC-COC</option>
                        <option>FACC</option>
                        <option>FUND TRANSFER</option>
                        <option>LED</option>
                        <option>Letter</option>
                        <option>Letter Request</option>
                        <option>Liquidated Damages</option>
                        <option>MEMO</option>
                        <option>MEMO / ORS / DV</option>
                        <option>Memo and Letter</option>
                        <option>Memo Endorsement</option>
                        <option>Mintues of the Meeting</option>
                        <option>MIS 2019 / FUND TRANSFER</option>
                        <option>MOA</option>
                        <option>MOM</option>
                        <option>ORS / DV</option>
                        <option>Payment</option>
                        <option>PCV</option>
                        <option>Perfomance Bond</option>
                        <option>PITC</option>
                        <option>PO/Contract & ORS</option>
                        <option>Policy</option>
                        <option>PR</option>
                        <option>Regional Concern</option>
                        <option>Reply letter</option>
                        <option>Salary</option>
                        <option>Site Replacement</option>
                        <option>SOA Service Reports</option>
                        <option>Termination by Convenience</option>
                        <option>UNDP</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="document_number" class="form-label">Document Number</label>
                    <input type="text" class="form-control" id="document_number" name="document_number" required>
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="remarks" class="form-label">Remarks</label>
                    <textarea class="form-control" id="remarks" name="remarks" rows="2"></textarea>
                </div>
                <div class="mb-3">
                    <label for="file" class="form-label">Attach File</label>
                    <input class="form-control" type="file" id="file" name="file">
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
                <!-- <button type="submit" class="btn btn-dark ms-4 position-absolute bottom-0 end-0 mb-3 me-3">Back</button> -->

                <a href="{{ route('login') }}" class="btn btn-outline-light     ">
                     Back 
                </a>
            </form>
        </div>
    </div>
</div>
@endsection