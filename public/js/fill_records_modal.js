// public/js/fill_records_modal.js
// ✅ Handles DB value "0000-00-00" => treat as NULL => display "Currently Working" for Employed
// ✅ If status is Terminated/Resigned => Date Ended is required, and "0000-00-00" is NOT allowed
// ✅ Switching statuses won't lose previous date_ended before saving

let cachedDateEnded = ""; // remembers last real end date while toggling

function firstPart(val) {
  if (!val) return "";
  return String(val).split("||")[0].trim();
}

function isZeroDate(val) {
  return String(val || "").trim() === "0000-00-00";
}

function normalizeEnded(val) {
  // treat "0000-00-00" as empty (NULL)
  if (!val) return "";
  const v = String(val).trim();
  if (isZeroDate(v)) return "";
  return v;
}

function toISODate(val) {
  if (!val) return "";
  val = String(val).trim();

  // filter zero-date early
  if (isZeroDate(val)) return "";

  if (/^\d{4}-\d{2}-\d{2}$/.test(val)) return val;
  if (/^\d{4}-\d{2}-\d{2}/.test(val)) return val.slice(0, 10);

  const m = val.match(/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/);
  if (m) {
    const a = parseInt(m[1], 10);
    const b = parseInt(m[2], 10);
    const y = m[3];

    let mm, dd;
    if (a > 12) {
      dd = a;
      mm = b;
    } else {
      mm = a;
      dd = b;
    }

    const pad = (n) => String(n).padStart(2, "0");
    return `${y}-${pad(mm)}-${pad(dd)}`;
  }

  return "";
}

function parseDateOnly(isoDate) {
  if (!isoDate) return null;
  return new Date(isoDate + "T00:00:00");
}

function needsEndDate(statusValue) {
  return statusValue === "Terminated" || statusValue === "Resigned/Retired";
}

function computeYearsOfService(startDate, endDate) {
  let years = endDate.getFullYear() - startDate.getFullYear();

  const endMonth = endDate.getMonth();
  const endDay = endDate.getDate();
  const startMonth = startDate.getMonth();
  const startDay = startDate.getDate();

  if (endMonth < startMonth || (endMonth === startMonth && endDay < startDay)) {
    years -= 1;
  }

  return Math.max(0, years);
}

function updateEditModalServiceFields() {
  const statusEl = document.getElementById("edit_status");
  const appointEl = document.getElementById("edit_date_of_appointment");

  const endedEl = document.getElementById("edit_date_ended"); // visible
  const endedHidden = document.getElementById("edit_date_ended_hidden"); // submitted
  const endedWrap = document.getElementById("edit_date_ended_wrap");

  const durationEl = document.getElementById("service_duration");
  const hintEl = document.getElementById("edit_date_ended_hint");

  if (!statusEl || !appointEl || !durationEl || !endedHidden) return;

  const status = statusEl.value;

  const startISO = toISODate(appointEl.value);
  const startDate = parseDateOnly(startISO);

  if (!startDate) {
    durationEl.value = "";
    if (endedEl) {
      endedEl.value = "";
      endedEl.required = false;
      endedEl.setCustomValidity("");
    }
    endedHidden.value = "";
    if (hintEl) hintEl.textContent = "";
    return;
  }

  // ✅ EMPLOYED: hide ended, duration text, and submit empty (backend can store 0000-00-00 or NULL)
  if (!needsEndDate(status)) {
    durationEl.value = "Currently Working";

    // cache ended before clearing (if user toggles back)
    if (endedEl && endedEl.value) {
      const cached = toISODate(endedEl.value);
      if (cached) cachedDateEnded = cached;
    }

    if (endedWrap) endedWrap.classList.add("d-none");
    if (hintEl)
      hintEl.textContent =
        "Currently Working (Date Ended will be saved as 0000-00-00 / NULL)";

    if (endedEl) {
      endedEl.value = "";
      endedEl.required = false;
      endedEl.setCustomValidity("");
    }

    endedHidden.value = ""; // controller: can convert to 0000-00-00 or NULL
    return;
  }

  // ✅ TERMINATED / RESIGNED: show ended, REQUIRE it, forbid 0000-00-00
  if (endedWrap) endedWrap.classList.remove("d-none");
  if (hintEl)
    hintEl.textContent =
      "Required: please select a valid Date Ended (not 0000-00-00)";

  if (endedEl) {
    endedEl.required = true;

    // restore cached ended if empty (when toggling back from employed)
    if (!endedEl.value && cachedDateEnded) endedEl.value = cachedDateEnded;
  }

  const endedISO = endedEl ? toISODate(endedEl.value) : "";
  endedHidden.value = endedISO;

  // Block invalid / empty ended date
  if (!endedISO) {
    if (endedEl) endedEl.setCustomValidity("Date Ended is required.");
    durationEl.value = "Waiting for end date";
    return;
  } else {
    if (endedEl) endedEl.setCustomValidity("");
  }

  const endDate = parseDateOnly(endedISO);
  if (!endDate) {
    durationEl.value = "Waiting for end date";
    return;
  }

  if (startDate > endDate) {
    durationEl.value = "Invalid dates";
    if (endedEl)
      endedEl.setCustomValidity(
        "Date Ended cannot be earlier than Date of Appointment.",
      );
    return;
  } else {
    if (endedEl) endedEl.setCustomValidity("");
  }

  const years = computeYearsOfService(startDate, endDate);
  durationEl.value = `${years} year${years !== 1 ? "s" : ""}`;
}

function openEditModal(rec) {
  document.getElementById("edit_id").value = rec.id ?? "";
  document.getElementById("edit_last_name").value = rec.last_name ?? "";
  document.getElementById("edit_first_name").value = rec.first_name ?? "";
  document.getElementById("edit_middle_name").value = rec.middle_name ?? "";
  document.getElementById("edit_extensions").value = rec.extensions ?? "";
  document.getElementById("edit_birthdate").value = toISODate(
    rec.birthdate ?? "",
  );
  document.getElementById("edit_gender").value = rec.gender ?? "";
  document.getElementById("edit_rate").value = rec.rate ?? "";
  document.getElementById("edit_educational_attainment").value =
    rec.educational_attainment ?? "";
  document.getElementById("edit_eligibility").value = rec.eligibility ?? "";
  document.getElementById("edit_remarks").value = rec.remarks ?? "";

  const dept = firstPart(rec.department);
  const desig = firstPart(rec.designation);

  const appoint = toISODate(firstPart(rec.date_of_appointment));
  const status = firstPart(rec.status) || "Employed";

  // normalize ended: if "0000-00-00" => empty
  const endedRaw = normalizeEnded(firstPart(rec.date_ended));
  const ended = toISODate(endedRaw);

  const deptEl = document.getElementById("edit_department");
  const desigEl = document.getElementById("edit_designation");
  if (deptEl) deptEl.value = dept;
  if (desigEl) desigEl.value = desig;

  document.getElementById("edit_date_of_appointment").value = appoint;
  document.getElementById("edit_status").value = status;

  const endedEl = document.getElementById("edit_date_ended");
  const endedHidden = document.getElementById("edit_date_ended_hidden");

  if (endedEl) endedEl.value = ended;
  if (endedHidden) endedHidden.value = ended;

  // init cache
  cachedDateEnded = ended || "";

  updateEditModalServiceFields();
}

document.addEventListener("DOMContentLoaded", () => {
  const statusEl = document.getElementById("edit_status");
  const appointEl = document.getElementById("edit_date_of_appointment");
  const endedEl = document.getElementById("edit_date_ended");

  if (statusEl)
    statusEl.addEventListener("change", updateEditModalServiceFields);
  if (appointEl)
    appointEl.addEventListener("change", updateEditModalServiceFields);

  if (endedEl) {
    endedEl.addEventListener("change", updateEditModalServiceFields);
    endedEl.addEventListener("input", updateEditModalServiceFields);
  }

  // ✅ On submit: enforce HTML validation messages (required/custom validity)
  const form = document.querySelector("#editModal form");
  if (form) {
    form.addEventListener("submit", (e) => {
      updateEditModalServiceFields(); // ensure latest validity
      if (!form.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
      }
      form.classList.add("was-validated");
    });
  }
});
