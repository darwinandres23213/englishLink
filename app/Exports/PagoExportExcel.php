<?php

namespace App\Exports;

use App\Models\Pago;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Http\Request;

class PagoExportExcel implements FromCollection, WithHeadings {
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Pago::query();
        if ($this->request->filled('matricula_id')) {
            $query->where('matricula_id', $this->request->matricula_id);
        }
        if ($this->request->filled('estudiante')) {
            $query->whereHas('matricula.estudiante', function($q) {
                $q->where('nombre', 'like', '%' . $this->request->estudiante . '%');
            });
        }
        if ($this->request->filled('curso')) {
            $query->whereHas('matricula.curso', function($q) {
                $q->where('nombre_curso', 'like', '%' . $this->request->curso . '%');
            });
        }
        if ($this->request->filled('estado')) {
            $query->where('estado_pago_id', $this->request->estado);
        }
        if ($this->request->filled('medio_pago')) {
            $query->where('medio_pago_id', $this->request->medio_pago);
        }
        if ($this->request->filled('fecha_inicio')) {
            $query->whereDate('fecha_pago', '>=', $this->request->fecha_inicio);
        }
        if ($this->request->filled('fecha_fin')) {
            $query->whereDate('fecha_pago', '<=', $this->request->fecha_fin);
        }
        return $query->get([
            'id_pago',
            'matricula_id',
            'monto',
            'fecha_pago',
            'estado_pago_id',
            'medio_pago_id',
        ]);
    }

    public function headings(): array
    {
        return ['ID Pago', 'Matrícula', 'Monto', 'Fecha Pago', 'Estado', 'Medio de Pago'];
    }
}
