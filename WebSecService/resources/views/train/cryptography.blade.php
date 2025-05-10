@extends('layouts.master')
@section('title', 'Cryptography')
@section('content')

<div class="card m-4">
  <div class="card-body">
      <form method="GET" action="{{ route('cryptography') }}">
          <div class="row mb-2">
              <div class="col">
                  <label for="data" class="form-label">Data:</label>
                  <input type="text" class="form-control" name="data" id="data" value="{{ $data }}" placeholder="Enter data to encrypt" required>
              </div>
          </div>
          <div class="row mb-2">
              <div class="col">
                  <label for="action" class="form-label">Operation:</label>
                  <select class="form-control" name="action" id="action" required>
                    <option {{($action=="Encrypt")?"selected":""}}>Encrypt</option>
                    <option {{($action=="Decrypt")?"selected":""}}>Decrypt</option>
                    <option {{($action=="Hash")?"selected":""}}>Hash</option>
                    <option {{($action=="Sign")?"selected":""}}>Sign</option>
                    <option {{($action=="Verify")?"selected":""}}>Verify</option>
                    <option {{($action=="KeySend")?"selected":""}}>KeySend</option>
                    <option {{($action=="KeyRecive")?"selected":""}}>KeyRecive</option>
                  </select>
              </div>
          </div>
          <div class="row mb-2">
              <div class="col">
                  <button type="submit" class="btn btn-primary">Submit</button>
              </div>
          </div>
      </form>
  </div>
</div>

<div class="card m-4">
  <div class="card-body">
      <h2><strong>Status:</strong> {{ $status }}</h2>
      <h2><strong>Result:</strong></h2>
      <textarea class="form-control" readonly>{{ $result }}</textarea>
  </div>
</div>
      


@endsection
