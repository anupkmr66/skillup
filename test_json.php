<?php
$data = ['name' => 'Test Course', 'desc' => 'It\'s "Quoted"'];
$json_apos = json_encode($data, JSON_HEX_APOS);
$json_full = json_encode($data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

echo "Standard + APOS: " . $json_apos . "\n";
echo "Full HEX: " . $json_full . "\n";
?>
<script>
    try {
        console.log("Parsing APOS:", JSON.parse('<?= $json_apos ?>'));
    } catch (e) { console.error("APOS failed:", e); }

    try {
        console.log("Parsing Full HEX:", JSON.parse('<?= $json_full ?>')); // This will fail syntax
    } catch (e) { console.error("Full HEX failed:", e.message); }
</script>