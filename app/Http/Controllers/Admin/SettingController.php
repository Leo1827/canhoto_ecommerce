<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    //
   public function index()
    {
        // Siempre habrá solo 1 registro de configuración
        $setting = Setting::first();

        // Si no existe, lo creamos vacío
        if (!$setting) {
            $setting = Setting::create([]);
        }

        return view('admin.setting.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::first();

        $data = $request->validate([
            'site_name' => 'nullable|string',
            'email_contacto' => 'nullable|string',
            'telefono_contacto' => 'nullable|string',
            'modo_oscuro' => 'nullable|boolean',
            'logo' => 'nullable|image',
            'favicon' => 'nullable|image',
        ]);

        // LOGO
        if ($request->hasFile('logo')) {
            if ($setting->logo) {
                Storage::disk('public')->delete($setting->logo);
            }
            $data['logo'] = $request->file('logo')->store('images/settings', 'public');
        }

        // FAVICON
        if ($request->hasFile('favicon')) {
            if ($setting->favicon) {
                Storage::disk('public')->delete($setting->favicon);
            }
            $data['favicon'] = $request->file('favicon')->store('images/settings', 'public');
        }

        $setting->update($data);

        return back()->with('success', 'Configurações atualizadas com sucesso!');
    }

    public function deleteField($campo)
    {
        $setting = Setting::first();

        if (!in_array($campo, ['logo', 'favicon'])) {
            return back()->with('error', 'Campo inválido.');
        }

        if ($setting->$campo) {
            Storage::disk('public')->delete($setting->$campo);
            $setting->update([$campo => null]);
        }

        return back()->with('success', ucfirst($campo) . ' removido com sucesso!');
    }
}
