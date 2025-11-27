<!-- XL Modal -->
<div class="modal fade" id="xlModal" tabindex="-1" role="dialog" aria-labelledby="xlModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="xlModalLabel">Extra Large Modal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p id="copyText"> </p>
            </div>

            <div class="modal-footer">
                <span id="inlineToast" class="ml-3 text-success d-none"> Text copied to clipboard! </span>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-outline-secondary" onclick="copyToClipboard()">Copy Text</button>
            </div>
        </div>
    </div>
</div>

<script>
  function copyToClipboard() {
    const text = document.getElementById("copyText").innerText.trim();
    if (!text) return;

    const toast = document.getElementById("inlineToast");

    if (navigator.clipboard) {
      navigator.clipboard.writeText(text).then(() => {
        toast.classList.remove("d-none");
        setTimeout(() => toast.classList.add("d-none"), 2000);
      });
    } else {
      const textarea = document.createElement("textarea");
      textarea.value = text;
      document.body.appendChild(textarea);
      textarea.select();
      document.execCommand("copy");
      document.body.removeChild(textarea);

      toast.classList.remove("d-none");
      setTimeout(() => toast.classList.add("d-none"), 2000);
    }
  }
</script>
