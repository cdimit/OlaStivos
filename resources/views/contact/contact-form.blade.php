@extends('layouts.app')
@section('styles')
    <link href="{{ asset('/css/headings/heading-in-pages.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container" style="background-color: #F9F9F9;">
    <div class="row" style="margin-top: 10px;">
        <p><h1>Επικοινωνήστε μαζί μας</h1></p>
        <div class="col-md-5">
            <p>
                Βοηθήστε μας να δημιουργήσουμε την πιο ολοκληρωμένη βάση δεδομένων με αποτελέσματα Κύπριων αθλητών του στίβου!
                Ενημερώστε μας για τυχόν προβλήματα ή λάθη που εντοπίσατε στην ιστοσελίδα μας ή στείλτε μας καινούργια αποτελέσματα αθλητών. 
            </p>
            <p>
                Σας πληροφορούμε ότι η ιστοσελίδα μας δημιουργήθηκε πρόσφατα και ο αρχικός μας στόχος είναι η καταχώρηση των πιο σημαντικών αποτελεσμάτων ιστορικά, όπως και στην ενημέρωση για αποτελέσματα που επιτεύχθηκαν κατά τα έτη 2017 και 2018. Η καταχώρηση παλαιότερων αποτελεσμάτων στην ιστοσελίδα μας γίνετε σταδιακά.
            </p>
            <p>
                Συμπληρώστε την φόρμα ή στείλτε email στο olastivos@gmail.com.
            </p>
            <div class="well">
                Advertisement
                Advertisement
                Advertisement
                Advertisement
                Advertisement
                Advertisement
            </div>
        </div>

        <div class="col-md-6 col-offset-1">
            @if(Session::has('success'))
               <div class="alert alert-success">
                 {{ Session::get('success') }}
               </div>
            @endif
            {!! Form::open(
                array(
                    'route' => 'contact.send',
                    'class' => 'form',
                    'files' => true)
                )
            !!}

            {{ csrf_field() }}

                <!--Name input field-->
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                    <label for="name" class="col-md-4 control-label">Ονοματεπώνυμο:</label>
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif

                </div>

                <!--Email input field-->
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label">Email:</label>
                    <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>

                <!--Τιτλος input field-->
                <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                    <label for="title" class="col-md-4 control-label">Τίτλος Μηνύματος:</label>

                    <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" required autofocus>

                    @if ($errors->has('title'))
                        <span class="help-block">
                            <strong>{{ $errors->first('title') }}</strong>
                        </span>
                    @endif
            
                </div>

                <!--Θέμα input field-->
                <div class="form-group{{ $errors->has('reason') ? ' has-error' : '' }}">
                    <label for="reason" class="col-md-4 control-label">Θέμα Μηνύματος:</label>
                    <select  id="reason" name="reason" class="form-control">
                            <option value="bug">Πρόβλημα Ιστοσελίδας(Bug)</option>
                            <option value="result">Λάθος αποτέλεσμα/ρεκόρ</option>
                            <option value="result">Άλλο</option>
                    </select>

                    @if ($errors->has('reason'))
                        <span class="help-block">
                            <strong>{{ $errors->first('reason') }}</strong>
                        </span>
                    @endif
                    
                </div>


                <!--message input field-->
                <div class="form-group{{ $errors->has('message') ? ' has-error' : '' }}">
                    <label for="message" class="col-md-4 control-label">Μήνυμα:</label>

                    <textarea id="message" rows="10" class="form-control" name="message" value="{{ old('message') }}" required autofocus></textarea>

                    @if ($errors->has('message'))
                        <span class="help-block">
                            <strong>{{ $errors->first('message') }}</strong>
                        </span>
                    @endif
                    
                </div>

               
                <div class="form-group center">
                    <label for="submit" class="col-md-4 control-label"></label>
                    <button type="submit" class="btn btn-primary">
                        Στείλε Μήνυμα
                    </button>

                </div>


            {!! Form::close() !!}
        </div>
    </div>
</div>


@endsection
