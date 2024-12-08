<?php

namespace App\Filament\Resources\GeneralDataResource\Widgets;

use Filament\Widgets\Widget;

class RecordWidget extends Widget
{
    protected static string $view = 'filament.resources.general-data-resource.widgets.record-widget';

    public string $title;
    public string $subtitle;
    public string $action;

    protected function getViewData(): array
    {
        return [
            'title' => $this->title,
            'subtitle' => $this->subtitle ?? '',
            'action' => $this->action ?? '',
        ];
    }
}
