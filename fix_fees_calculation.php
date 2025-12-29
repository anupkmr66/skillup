<?php
require_once 'core/Database.php';

try {
    $db = Database::getInstance();
    echo "Checking and fixing fee calculations...\n";

    $fees = $db->fetchAll("SELECT * FROM fees");
    $count = 0;

    foreach ($fees as $fee) {
        $total = (float) $fee['total_fee'];
        $discount = (float) ($fee['discount_amount'] ?? 0);
        $paid = (float) $fee['paid_amount'];
        $currentDue = (float) $fee['due_amount'];

        $correctDue = $total - $discount - $paid;

        // Round to 2 precision to avoid float diffs
        if (abs($currentDue - $correctDue) > 0.01) {
            echo "Fixing Fee ID {$fee['id']}: Current Due ($currentDue) -> Correct Due ($correctDue)\n";

            $status = $correctDue <= 0 ? 'paid' : ($paid > 0 ? 'partial' : 'unpaid');

            $db->update('fees', [
                'due_amount' => $correctDue,
                'status' => $status
            ], 'id = ' . $fee['id']);

            $count++;
        }
    }

    echo "Fixed $count records.\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
