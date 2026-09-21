<?php

namespace App\Listeners;

use App\Enums\AuditTypeEnum;
use App\Events\UserSaved;
use App\Models\User;
use App\Models\UserAudit;
use Carbon\Carbon;
use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class LogUserSave implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(UserSaved $event): void
    {
        $user = $event->user;
        $type = $event->type;
        $savedFields = $event->savedFields;
        $originalFields = $event->originalFields;

        if ($type === 'created') {
            $data = $this->created($user);
        } else {
            $data = $this->updated($user, $savedFields, $originalFields);
        }

        UserAudit::create([
            'user_id'       => $user->id,
            'audit_type_id' => $type === 'created' ? AuditTypeEnum::ADD : AuditTypeEnum::UPDATE,
            'data'          => json_encode($data),
            'created_by'    => Auth::id() ?? Auth::systemUser()->id,
        ]);
    }

    private function created(User $user): array
    {
        $userData = $user->getAttributes();
        $fields = [];
        $this->removeUnimportantFields($userData);

        foreach ($userData as $field => $value) {
            if (
                empty($value)
                || in_array($field, ['first_name', 'middle_name', 'last_name', 'username'])
            ) {
                continue;
            }
            if (in_array($field, ['first_name_index', 'middle_name_index', 'last_name_index', 'username_index'])) {
                $field = str_replace('_index', '', $field);
            }

            if ($field === 'password') {
                $value = 'encrypted';
            }

            $fields[] = [
                'field' => $field,
                'from'  => null,
                'to'    => $value,
            ];
        }

        return [
            'title'  => 'User has been added.',
            'fields' => $fields,
        ];
    }

    private function updated(
        User $user,
        array $savedFields,
        array $originalFields,
    ): array {
        $fields = [];
        $this->removeUnimportantFields($savedFields);

        foreach ($savedFields as $field => $newValue) {
            if (in_array($field, ['first_name_index', 'middle_name_index', 'last_name_index', 'username_index'])) {
                continue;
            }
            $oldValue = $originalFields[$field];

            if ($user->hasCast($field, 'encrypted')) {
                try {
                    $newValue = Crypt::decryptString($newValue);
                } catch (DecryptException $e) {
                }
            }

            $castType = $user->getCasts()[$field] ?? '';
            $isDate = str_starts_with($castType, 'date') || str_starts_with($castType, 'datetime');

            if ($isDate) {
                // Safely extract the format or fall back to your default string template
                $format = str_contains($castType, ':')
                    ? explode(':', $castType, 2)[1]
                    : 'M d Y, h:i:s a';

                // Safely parse and convert values with Carbon
                if ($oldValue) {
                    $oldValue = Carbon::parse($oldValue)->format($format);
                }
                if ($newValue) {
                    $newValue = Carbon::parse($newValue)->format($format);
                }
            }

            if ($field === 'password') {
                $oldValue = 'encrypted';
                $newValue = 'encrypted';
            }

            $fields[] = [
                'field' => $field,
                'from'  => $oldValue,
                'to'    => $newValue,
            ];
        }

        return [
            'title'  => 'User has been updated.',
            'fields' => $fields,
        ];
    }

    private function removeUnimportantFields(array &$fields): void
    {
        $exclude = [
            'id', 'created_by', 'created_at',
            'last_modified_by', 'updated_at',
        ];

        foreach ($exclude as $key) {
            unset($fields[$key]);
        }
    }
}
