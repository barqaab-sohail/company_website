<?php

namespace App\Filament\Resources\JobApplications\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\{FileUpload, Repeater, Select, Textarea, TextInput};

class JobApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('job_opening_id')->relationship('jobOpening','title')->searchable()->placeholder('General Purpose'), Select::make('application_type')->options(['general'=>'General Purpose','job'=>'Specific Job'])->required(),
                TextInput::make('first_name'), TextInput::make('last_name'), TextInput::make('email')->email()->required(), TextInput::make('phone'), TextInput::make('address'), TextInput::make('city'),
                Select::make('contact_type')->options(['home'=>'Home','mobile'=>'Mobile','work'=>'Work','other'=>'Other']), TextInput::make('total_experience')->numeric()->suffix('years'),
                Repeater::make('education')->schema([TextInput::make('qualification')->required(),TextInput::make('year')->numeric()->minValue(1940)->maxValue((int)date('Y'))])->columns(2)->columnSpanFull(),
                Select::make('status')->options(['new'=>'New','reviewing'=>'Reviewing','shortlisted'=>'Shortlisted','rejected'=>'Rejected'])->required(), FileUpload::make('resume_path')->disk('public')->directory('resumes')->acceptedFileTypes(['application/pdf','application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document']), Textarea::make('cover_letter')->columnSpanFull(),
            ]);
    }
}
