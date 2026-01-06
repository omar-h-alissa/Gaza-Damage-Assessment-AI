<?php

namespace App\Http\Livewire\Permission;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Livewire\Attributes\On;
use Illuminate\Validation\Rule; // تأكد من وجود هذا الاستيراد

class RoleModal extends Component
{
    public $name = '';
    public $checked_permissions = [];
    public $check_all = false;

    public Role $role;

    public Collection $permissions;

    // **التعديل الجذري: تحويل $rules إلى دالة rules()**
    // هذا يضمن أن يتم استدعاء القواعد دائماً بناءً على حالة الكومبوننت الحالية
    protected function rules()
    {
        // إذا كان الدور موجوداً (تعديل)، استثنِ الـ ID الخاص به.
        $roleId = $this->role->id ?? null;

        return [
            'name' => [
                'required',
                'string',
                // نستخدم Rule::unique ونستثني الـ ID الحالي (إذا كان موجوداً)
                Rule::unique('roles', 'name')->ignore($roleId),
            ],
        ];
    }

    // **حذف دالة updated بالكامل**
    // بما أننا استخدمنا دالة rules()، لم نعد بحاجة لـ updated لتحديث القواعد

    #[On('modal.show.role_name')]
    public function mountRole($roleId = null)
    {
        // إعادة تعيين الحالة عند فتح المودال
        $this->reset(['name', 'checked_permissions', 'check_all']);
        $this->resetErrorBag();

        $this->permissions = Permission::all();

        if (empty($roleId)) {
            // حالة الإضافة: إنشاء Role جديدة
            $this->role = new Role;
            $this->name = '';
            $this->checked_permissions = [];

        } else {
            // حالة التعديل: جلب Role الموجودة
            $role = Role::find($roleId);
            if (is_null($role)) {
                $this->dispatch('error', 'The selected role ID [' . $roleId . '] is not found');
                // إرسال حدث لتحديث قائمة الأدوار في الكومبوننت الرئيسي
                $this->dispatch('refresh-roles');
                return;
            }

            $this->role = $role;
            $this->name = $this->role->name;
            $this->checked_permissions = $this->role->permissions->pluck('name')->toArray();

            // فحص حالة "Select all" عند التحميل
            if ($this->permissions->count() > 0 && count($this->checked_permissions) === $this->permissions->count()) {
                $this->check_all = true;
            }
        }
    }

    public function mount()
    {
        $this->permissions = new Collection();
        $this->role = new Role();
    }

    public function render()
    {
        // ... (كود الـ render لم يتغير)
        $permissions_by_group = [];
        foreach ($this->permissions ?? [] as $permission) {
            $parts = explode(' ', $permission->name, 2);
            $ability = count($parts) > 1 ? $parts[1] : $permission->name;
            $permissions_by_group[$ability][] = $permission;
        }

        return view('livewire.permission.role-modal', compact('permissions_by_group'));
    }

    public function submit()
    {
        // التحقق سيتم بناءً على دالة rules() التي تحدثنا عنها أعلاه
        $this->validate();

        if (!$this->role->exists) {
            // إنشاء دور جديد
            $this->role = Role::create(['name' => $this->name]);
            $message = 'Role [' . ucwords($this->role->name) . '] created successfully.';
        } else {
            // تعديل دور موجود
            $this->role->name = $this->name;
            $this->role->save();
            $message = 'Role [' . ucwords($this->role->name) . '] updated successfully.';
        }

        $this->role->syncPermissions($this->checked_permissions);

        // إطلاق أحداث للإغلاق والتحديث
        $this->dispatch('success', $message);
        $this->dispatch('close-modal');
        $this->dispatch('refresh-roles');
    }

    // ... (بقية الدوال)
    public function checkAll()
    {
        if ($this->check_all) {
            $this->checked_permissions = $this->permissions->pluck('name')->toArray();
        } else {
            $this->checked_permissions = [];
        }
    }
}
