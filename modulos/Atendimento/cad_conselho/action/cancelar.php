<?php


Conselho_ufDAO::delete($frm->get('codigo'));
ConselhoDAO::delete($frm->get('codigo'));

echo "Conselho excluído com sucesso";
?>
