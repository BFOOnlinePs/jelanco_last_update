<?php

namespace App\Observers;

use App\Models\ProductActivityLogModel;
use App\Models\ProductNotesModel;

class ProductNoteObserver
{
    public function created(ProductNotesModel $note): void
    {
        ProductActivityLogModel::logActivity(
            $note->product_id,
            'add_note',
            'تم إضافة ملاحظة للمنتج',
            null,
            null,
            $note->notes
        );
    }

    public function deleted(ProductNotesModel $note): void
    {
        ProductActivityLogModel::logActivity(
            $note->product_id,
            'delete_note',
            'تم حذف ملاحظة من المنتج',
            null,
            $note->notes,
            null
        );
    }
}
