<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;

class UserImport implements ToModel, WithValidation
{
    public function model(array $row)
    {
        $user = new User([
            'name' => $row[0],
            'email' => $row[1],
        ]);

        if (isset($row[2])) {
            $thumbnail = $row[2];
            $thumbnailName = $user->id . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->storeAs('thumbnails', $thumbnailName);
            $user->thumbnail = $thumbnailName;
        }

        return $user;
    }

    public function rules(): array
    {
        return [
            '*.0' => 'required',
            '*.1' => 'required|unique:users,email',
            '*.2' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}


?>