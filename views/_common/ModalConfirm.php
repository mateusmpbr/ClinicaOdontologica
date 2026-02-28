<?php
$modalId = $modalId ?? 'confirmModal';
$modalTitle = $modalTitle ?? 'Confirmar';
$modalBody = $modalBody ?? '';
$formAction = $formAction ?? '';
$hiddenFields = $hiddenFields ?? [];
$confirmButtonName = $confirmButtonName ?? '';
$confirmButtonLabel = $confirmButtonLabel ?? 'Confirmar';
?>
<div class="modal fade" id="<?= htmlspecialchars($modalId) ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?= htmlspecialchars($modalTitle) ?></h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body"><?= htmlspecialchars($modalBody) ?></div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
        <form action="<?= htmlspecialchars($formAction) ?>" method="post">
          <?php foreach ($hiddenFields as $name => $value) : ?>
            <input type="hidden" name="<?= htmlspecialchars($name) ?>" value="<?= htmlspecialchars($value) ?>">
          <?php endforeach; ?>
          <?php if (function_exists('csrf_field')) : ?>
            <?= csrf_field() ?>
          <?php endif; ?>
          <button type="submit" class="btn btn-primary" name="<?= htmlspecialchars($confirmButtonName) ?>"><?= htmlspecialchars($confirmButtonLabel) ?></button>
        </form>
      </div>
    </div>
  </div>
</div>
