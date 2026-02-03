// public/js/edit_dynamic_services.js
// ✅ FULL WORKING CODE: Edit modal shows Date Ended + Duration when status is Resigned/Retired or Terminated



function splitPipe(val) {
  if (!val) return [];
  return String(val)
    .split("||")
    .map((s) => s.trim());
}

function isZeroDate(v) {
  return String(v || "").trim() === "0000-00-00";
}

// Accepts: "YYYY-MM-DD", "YYYY-MM-DD HH:mm:ss", "YYYY-MM-DDTHH:mm"
function toISODate(val) {
  if (!val) return "";
  val = String(val).trim();
  if (isZeroDate(val)) return "";
  if (/^\d{4}-\d{2}-\d{2}$/.test(val)) return val;
  if (/^\d{4}-\d{2}-\d{2}/.test(val)) return val.slice(0, 10);
  return "";
}

function parseDateOnly(iso) {
  return iso ? new Date(iso + "T00:00:00") : null;
}

function needsEndDate(status) {
  return status === "Terminated" || status === "Resigned/Retired";
}

function daysInMonth(year, monthIndex) {
  return new Date(year, monthIndex + 1, 0).getDate();
}

function diffYMD(fromDate, toDate) {
  let y = toDate.getFullYear() - fromDate.getFullYear();
  let m = toDate.getMonth() - fromDate.getMonth();
  let d = toDate.getDate() - fromDate.getDate();

  if (d < 0) {
    m -= 1;
    const prevMonth = (toDate.getMonth() - 1 + 12) % 12;
    const prevMonthYear =
      prevMonth === 11 ? toDate.getFullYear() - 1 : toDate.getFullYear();
    d += daysInMonth(prevMonthYear, prevMonth);
  }

  if (m < 0) {
    y -= 1;
    m += 12;
  }

  return { years: y, months: m, days: d };
}

function formatDuration({ years, months, days }) {
  const parts = [];
  if (years > 0) parts.push(`${years} year${years !== 1 ? "s" : ""}`);
  if (months > 0) parts.push(`${months} month${months !== 1 ? "s" : ""}`);
  if (days > 0) parts.push(`${days} day${days !== 1 ? "s" : ""}`);
  return parts.length ? parts.join(", ") : "0 days";
}

function createEditServiceRow(container) {
  const tpl = document.getElementById("editServiceRowTpl");
  if (!tpl) {
    console.error("❌ Template #editServiceRowTpl not found!");
    return null;
  }
  const node = tpl.content.cloneNode(true);
  container.appendChild(node);
  const rows = container.querySelectorAll(".service-row");
  return rows[rows.length - 1];
}

function renumberBadges(container) {
  container.querySelectorAll(".service-row").forEach((row, idx) => {
    const badge = row.querySelector(".js-service-index");
    if (badge) badge.textContent = `Service ${idx + 1}`;
  });
}

function updateServiceRow(row) {
  const statusEl = row.querySelector(".js-status");
  const appointEl = row.querySelector(".js-appoint");

  const endedRow = row.querySelector(".js-ended-row");
  const endedEl = row.querySelector(".js-ended"); // datetime-local (visible)
  const endedHidden = row.querySelector(".js-ended-hidden"); // hidden date_ended[]
  const hintEl = row.querySelector(".js-ended-hint");
  const durationEl = row.querySelector(".js-duration");

  const status = (statusEl?.value || "").trim();

  const startISO = toISODate(appointEl?.value || "");
  const startDate = parseDateOnly(startISO);

  // reset validity
  if (endedEl) {
    endedEl.required = false;
    endedEl.setCustomValidity("");
  }

  // If no start date yet
  if (!startDate) {
    if (endedRow) endedRow.classList.add("d-none");
    if (durationEl) durationEl.value = "";
    if (endedHidden) endedHidden.value = "";
    if (hintEl) hintEl.textContent = "";
    return;
  }

  // ✅ EMPLOYED => hide ended row
  if (!needsEndDate(status)) {
    if (endedRow) endedRow.classList.add("d-none");
    if (endedEl) endedEl.value = "";
    if (endedHidden) endedHidden.value = "0000-00-00";
    if (durationEl) durationEl.value = "Currently Working";
    if (hintEl) hintEl.textContent = "Currently Working";
    return;
  }

  // ✅ TERMINATED / RESIGNED => show ended row
  if (endedRow) endedRow.classList.remove("d-none");
  if (hintEl) hintEl.textContent = "Required";
  if (endedEl) endedEl.required = true;

  // endedEl is datetime-local; store DATE part only in hidden
  const endedDt = endedEl?.value || "";
  const endedISO = toISODate(endedDt); // YYYY-MM-DD from datetime-local
  if (endedHidden) endedHidden.value = endedISO;

  if (!endedISO) {
    if (durationEl) durationEl.value = "Waiting for end date";
    if (endedEl) endedEl.setCustomValidity("Date Ended is required.");
    return;
  }

  const endDate = parseDateOnly(endedISO);
  if (!endDate) {
    if (durationEl) durationEl.value = "Waiting for end date";
    return;
  }

  if (startDate > endDate) {
    if (durationEl) durationEl.value = "Invalid dates";
    if (endedEl)
      endedEl.setCustomValidity(
        "Date Ended cannot be earlier than Date of Appointment.",
      );
    return;
  }

  if (endedEl) endedEl.setCustomValidity("");
  if (durationEl)
    durationEl.value = formatDuration(diffYMD(startDate, endDate));
}

function resetRow(row) {
  row.querySelectorAll("select").forEach((s) => (s.selectedIndex = 0));
  row.querySelectorAll("input").forEach((i) => (i.value = ""));

  const endedRow = row.querySelector(".js-ended-row");
  if (endedRow) endedRow.classList.add("d-none");

  const endedHidden = row.querySelector(".js-ended-hidden");
  if (endedHidden) endedHidden.value = "0000-00-00";

  const durationEl = row.querySelector(".js-duration");
  if (durationEl) durationEl.value = "";
}

function bindRowEvents(row) {
  // Live updates
  row.addEventListener("change", (e) => {
    if (
      e.target.classList.contains("js-status") ||
      e.target.classList.contains("js-appoint") ||
      e.target.classList.contains("js-ended")
    ) {
      updateServiceRow(row);
    }
  });

  row.addEventListener("input", (e) => {
    if (e.target.classList.contains("js-ended")) updateServiceRow(row);
  });

  // Row add button
  const addBtn = row.querySelector(".js-add-service");
  if (addBtn) {
    addBtn.addEventListener("click", () => {
      const container = document.getElementById("editServiceContainer");
      const newRow = createEditServiceRow(container);
      if (!newRow) return;

      bindRowEvents(newRow);

      const statusEl = newRow.querySelector(".js-status");
      const endedHidden = newRow.querySelector(".js-ended-hidden");
      if (statusEl) statusEl.value = "Employed";
      if (endedHidden) endedHidden.value = "0000-00-00";

      updateServiceRow(newRow);
      renumberBadges(container);
    });
  }

  // Row remove button
  const removeBtn = row.querySelector(".js-remove-service");
  if (removeBtn) {
    removeBtn.addEventListener("click", () => {
      const container = document.getElementById("editServiceContainer");
      const all = container.querySelectorAll(".service-row");

      if (all.length <= 1) {
        resetRow(row);
        updateServiceRow(row);
        return;
      }

      row.remove();
      renumberBadges(container);
    });
  }
}

function fillRow(row, data) {
  const deptEl = row.querySelector(".js-dept");
  const desigEl = row.querySelector(".js-desig");
  const rateEl = row.querySelector(".js-rate");
  const appointEl = row.querySelector(".js-appoint");
  const statusEl = row.querySelector(".js-status");

  const endedEl = row.querySelector(".js-ended"); // datetime-local visible
  const endedHidden = row.querySelector(".js-ended-hidden");

  if (deptEl) deptEl.value = data.department || "";
  if (desigEl) desigEl.value = data.designation || "";
  if (rateEl) rateEl.value = data.rate || "";
  if (appointEl) appointEl.value = toISODate(data.date_of_appointment || "");

  if (statusEl) statusEl.value = (data.status || "Employed").trim();

  const endedISO = toISODate(data.date_ended || "");
  if (endedEl) endedEl.value = endedISO ? `${endedISO}T00:00` : "";
  if (endedHidden)
    endedHidden.value =
      endedISO || ((statusEl?.value || "") === "Employed" ? "0000-00-00" : "");

  // ✅ force update (fix for modal not showing ended row)
  if (statusEl) statusEl.dispatchEvent(new Event("change", { bubbles: true }));
  if (appointEl)
    appointEl.dispatchEvent(new Event("change", { bubbles: true }));

  updateServiceRow(row);
}

window.openEditModal = function (rec) {
  // employee fields
  document.getElementById("edit_id").value = rec.id ?? "";
  document.getElementById("edit_last_name").value = rec.last_name ?? "";
  document.getElementById("edit_first_name").value = rec.first_name ?? "";
  document.getElementById("edit_middle_name").value = rec.middle_name ?? "";
  document.getElementById("edit_extensions").value = rec.extensions ?? "";
  document.getElementById("edit_birthdate").value = toISODate(
    rec.birthdate ?? "",
  );
  document.getElementById("edit_gender").value = rec.gender ?? "Male";
  document.getElementById("edit_educational_attainment").value =
    rec.educational_attainment ?? "";
  document.getElementById("edit_eligibility").value = rec.eligibility ?? "NON";
  document.getElementById("edit_remarks").value = rec.remarks ?? "";

  // service arrays from record (pipe strings)
  const departments = splitPipe(rec.department);
  const designations = splitPipe(rec.designation);
  const rates = splitPipe(rec.rate);
  const appoints = splitPipe(rec.date_of_appointment);
  const statuses = splitPipe(rec.status);
  const endeds = splitPipe(rec.date_ended);

  const container = document.getElementById("editServiceContainer");
  container.innerHTML = "";

  const maxLen = Math.max(
    departments.length,
    designations.length,
    rates.length,
    appoints.length,
    statuses.length,
    endeds.length,
    1,
  );

  for (let i = 0; i < maxLen; i++) {
    const row = createEditServiceRow(container);
    if (!row) continue;

    bindRowEvents(row);

    fillRow(row, {
      department: departments[i] || "",
      designation: designations[i] || "",
      rate: rates[i] || "",
      date_of_appointment: appoints[i] || "",
      status: statuses[i] || "Employed",
      date_ended: endeds[i] || "",
    });
  }

  renumberBadges(container);
};

document.addEventListener("DOMContentLoaded", () => {
  const container = document.getElementById("editServiceContainer");
  const form = document.getElementById("editForm");
  const addBtn = document.getElementById("editAddServiceBtn");
  const modalEl = document.getElementById("editModal");

  // Top Add Service button
  if (addBtn && container) {
    addBtn.addEventListener("click", () => {
      const row = createEditServiceRow(container);
      if (!row) return;

      bindRowEvents(row);

      const statusEl = row.querySelector(".js-status");
      const endedHidden = row.querySelector(".js-ended-hidden");
      if (statusEl) statusEl.value = "Employed";
      if (endedHidden) endedHidden.value = "0000-00-00";

      updateServiceRow(row);
      renumberBadges(container);
    });
  }

  // Submit: sync hidden ended values + validate
  if (form && container) {
    form.addEventListener("submit", (e) => {
      container.querySelectorAll(".service-row").forEach(updateServiceRow);

      if (!form.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
      }
      form.classList.add("was-validated");
    });
  }

  // ✅ CRITICAL: When modal is shown, FORCE update all rows (fix hidden ended row issue)
  if (modalEl && container) {
    modalEl.addEventListener("shown.bs.modal", () => {
      setTimeout(() => {
        container.querySelectorAll(".service-row").forEach(updateServiceRow);
      }, 100);
    });
  }
});
