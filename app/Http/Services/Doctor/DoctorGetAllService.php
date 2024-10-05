<?php

namespace App\Http\Services\Doctor;

use Illuminate\Http\Request;

class DoctorGetAllService extends DoctorService
{
    public function boot(Request $request)
    {
        $default_avatar = [
            "male" => env("APP_URL") . "/images/male_avatar.webp",
            "female" => env("APP_URL") . "/images/female_avatar.jpg",
        ];

        // Fetch all columns from your model's table
        $data = $this->model->where("is_doctor", true);

        if ($request->has('search') && $request->search != "") {
            $data->where(function ($q) use ($request) {
                $q->where("name", "like", "%" . $request->search . "%")->orWhere("phone", "like", "%" . $request->search . "%");
            });
        }

        $data = $data->latest()->paginate(12);

        // Add avatar URL to each doctor's data
        $data->getCollection()->transform(function ($doctor) use ($default_avatar) {
            $doctor->avatar_url = $doctor->getFirstMediaUrl('avatar') ?: $default_avatar[strtolower($doctor->gender)];
            unset($doctor->media);
            return $doctor;
        });

        return $data;
    }
}
