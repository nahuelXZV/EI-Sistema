<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Model;

class PostgraduateForm extends Model
{
    public static function rules()
    {
        return [
            'postgraduateForm.nombre_completo' => 'required|string|max:255',
            'postgraduateForm.genero' => 'required|string',
            'postgraduateForm.es_boliviano' => 'required|boolean',
            'postgraduateForm.ci' => 'string|max:255',
            'postgraduateForm.ci_expedido' => 'string|max:255',
            'postgraduateForm.telefono' => 'string|max:255',
            'postgraduateForm.pasaporte' => 'nullable|string|max:255',
            'postgraduateForm.whatsapp' => 'required|string|max:15',
            'postgraduateForm.email' => 'required|email|max:255',
            'postgraduateForm.profesion' => 'required|string|max:255',
            'postgraduateForm.universidad_origen' => 'required|string|max:255',
            'postgraduateForm.anio_egreso' => 'required|integer',
            'postgraduateForm.registro_uagrm' => 'nullable|string|max:255',
            'postgraduateForm.institucion_trabajo' => 'required|string|max:255',
            'postgraduateForm.url_foto' => 'required|string',
            'postgraduateForm.experiencia_laboral' => 'required|string',
        ];
    }

    public static function messages()
    {
        return [
            'postgraduateForm.nombre_completo.required' => 'El nombre completo es obligatorio.',
            'postgraduateForm.genero.required' => 'Debe seleccionar un género.',
            'postgraduateForm.es_boliviano.required' => 'Debe indicar si es boliviano o no.',
            'postgraduateForm.ci.required' => 'El carnet de identidad es obligatorio.',
            'postgraduateForm.ci_expedido.required' => 'Debe completar la expedición del CI.',
            'postgraduateForm.telefono.required' => 'El teléfono es obligatorio.',
            'postgraduateForm.whatsapp.required' => 'Debe ingresar su número de WhatsApp.',
            'postgraduateForm.whatsapp.max' => 'El número de WhatsApp no debe superar los 15 caracteres.',
            'postgraduateForm.email.required' => 'El correo electrónico es obligatorio.',
            'postgraduateForm.email.email' => 'Debe ingresar un correo electrónico válido.',
            'postgraduateForm.profesion.required' => 'Debe ingresar su profesión.',
            'postgraduateForm.universidad_origen.required' => 'Debe ingresar su universidad de origen.',
            'postgraduateForm.anio_egreso.required' => 'Debe ingresar su año de egreso.',
            'postgraduateForm.anio_egreso.integer' => 'El año de egreso debe ser un número.',
            'postgraduateForm.url_foto.required' => 'Debe subir una foto.',
            'postgraduateForm.experiencia_laboral.required' => 'Debe describir su experiencia laboral.',
            'postgraduateForm.institucion_trabajo.required' => 'Debe ingresar la institución donde trabaja.',
        ];
    }

    public static function Inicializar()
    {
        return [
            'programa_id' => 0,
            'nombre_completo' => "",
            'genero' => "",
            'es_boliviano' => false,
            'ci' => "",
            'ci_expedido' => "",
            'telefono' => "",
            'pasaporte' => "",
            'whatsapp' => "",
            'email' => "",
            'profesion' => "",
            'universidad_origen' => "",
            'anio_egreso' => 0,
            'registro_uagrm' => "",
            'institucion_trabajo' => "",
            'url_foto' => "",
            'experiencia_laboral' => "",
        ];
    }

    public static function sync($registrationForm)
    {
        return [
            'id' => $registrationForm->id,
            'program_id' => $registrationForm->program_id,
            'nombre_completo' => $registrationForm->nombre_completo,
            'genero' => $registrationForm->genero,
            'es_boliviano' => $registrationForm->es_boliviano,
            'ci' => $registrationForm->ci,
            'ci_expedido' => $registrationForm->ci_expedido,
            'pasaporte' => $registrationForm->pasaporte,
            'telefono' => $registrationForm->telefono,
            'whatsapp' => $registrationForm->whatsapp,
            'email' => $registrationForm->email,
            'profesion' => $registrationForm->profesion,
            'universidad_origen' => $registrationForm->universidad_origen,
            'anio_egreso' => $registrationForm->anio_egreso,
            'registro_uagrm' => $registrationForm->registro_uagrm,
            'institucion_trabajo' => $registrationForm->institucion_trabajo,
            'url_foto' => $registrationForm->url_foto,
            'experiencia_laboral' => $registrationForm->experiencia_laboral,
        ];
    }
}
