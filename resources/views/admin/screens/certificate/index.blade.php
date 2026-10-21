<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Student Certificates ({{ $registrations->count() }}) - IntSource</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@600;700&family=Playfair+Display:wght@700;800&family=Poppins:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />

    <style>
      * {
        box-sizing: border-box;
      }

      @page {
        size: A4 landscape;
        margin: 0;
      }

      body {
        margin: 0;
        padding: 0;
        background: #0f141e;
        font-family: "Poppins", sans-serif;
        color: #09275e;
      }

      /* Screen floating toolbar */
      .no-print {
        position: sticky;
        top: 0;
        z-index: 999;
        background: #11161f;
        border-bottom: 1px solid #232c3d;
        padding: 12px 24px;
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        color: #e8ecf4;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.5);
      }

      .toolbar-left,
      .toolbar-right {
        display: flex;
        align-items: center;
        gap: 12px;
      }

      .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.2s ease;
        border: none;
      }

      .btn-secondary {
        background: #171e2b;
        color: #cbd5e1;
        border: 1px solid #334155;
      }

      .btn-secondary:hover {
        background: #232c3d;
        color: #ffffff;
      }

      .btn-primary {
        background: #f59e0b;
        color: #090d14;
        box-shadow: 0 4px 14px rgba(245, 158, 11, 0.3);
      }

      .btn-primary:hover {
        background: #fbbf24;
        transform: translateY(-1px);
      }

      .badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 9999px;
        font-family: monospace;
        font-size: 12px;
        background: rgba(16, 185, 129, 0.15);
        color: #34d399;
        border: 1px solid rgba(16, 185, 129, 0.3);
      }

      .certificates-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 28px;
        padding: 24px 0 48px;
      }

      /* A4 landscape certificate canvas */
      .certificate {
        position: relative;
        width: 297mm;
        height: 210mm;
        margin: 0 auto;
        overflow: hidden;
        background: #fff
          url("{{ asset('images/certificate_bg.png') }}") center / 100% 100%
          no-repeat;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
        print-color-adjust: exact;
        -webkit-print-color-adjust: exact;
        page-break-after: always;
        break-after: page;
      }

      .certificate:last-child {
        page-break-after: auto;
        break-after: auto;
      }

      /* Header logos */
      .company-logo {
        position: absolute;
        top: 7.2%;
        left: 9.5%;
        width: 22%;
        height: 11%;
        object-fit: contain;
        object-position: left center;
      }

      .college-logo {
        position: absolute;
        top: 6.1%;
        right: 4.3%;
        width: 27%;
        height: 13%;
        object-fit: contain;
        object-position: right center;
      }

      /* Main certificate heading */
      .heading {
        position: absolute;
        top: 18.3%;
        left: 0;
        width: 100%;
        text-align: center;
      }

      .heading h1 {
        margin: 0;
        font-family: "Playfair Display", serif;
        font-size: 16.2mm;
        font-weight: 800;
        line-height: 1.2;
        letter-spacing: 1.1mm;
        color: #09275e;
      }

      .heading .subtitle {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4mm;
        margin-top: 1mm;
        font-size: 3.8mm;
        font-weight: 600;
        letter-spacing: 1.7mm;
      }

      .heading .subtitle::before,
      .heading .subtitle::after {
        content: "";
        display: block;
        width: 27mm;
        height: 0.5mm;
        background: #d99a00;
      }

      /* Certificate recipient */
      .presented {
        position: absolute;
        top: 35.7%;
        left: 0;
        width: 100%;
        text-align: center;
        font-size: 4mm;
        font-weight: 400;
      }

      .student-name {
        position: absolute;
        top: 40.1%;
        left: 50%;
        width: max-content
        height: 10.5%;
        display: flex;
        align-items: center;
        justify-content: center;
        transform: translateX(-50%);

        font-family: "Dancing Script", cursive;
        font-size: 13mm;
        font-weight: 700;
        color: #09275e;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;

        border-bottom: 0.45mm solid #d99a00;
      }

      /* Course completion details */
      .completion {
        position: absolute;
        top: 54%;
        left: 10%;
        width: 80%;
        text-align: center;
        font-size: 3.8mm;
        line-height: 1.55;
      }

      .completion p {
        margin: 0;
      }

      .completion strong {
        font-weight: 700;
        color: #09275e;
      }

      .training-partners {
        font-weight: 600;
      }

      .description {
        position: absolute;
        top: 66.8%;
        left: 12%;
        width: 76%;
        text-align: center;
        font-size: 3.3mm;
        line-height: 1.6;
      }

      /* Signature row */
      .signatures {
        position: absolute;
        left: 8.8%;
        bottom: 7.3%;
        width: 82.4%;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8mm;
        align-items: end;
      }

      .signature {
        text-align: center;
        min-width: 0;
      }

      .signature img {
        display: block;
        width: 45mm;
        height: 15mm;
        object-fit: contain;
        margin: 0 auto -1mm;
      }

      .signature .line {
        width: 100%;
        height: 0.4mm;
        background: #d99a00;
      }

      .signature h3 {
        margin: 2mm 0 0.5mm;
        font-size: 3.5mm;
        font-weight: 700;
        text-transform: uppercase;
      }

      .signature .name {
        font-weight: bold;
        margin-top: 5px;
      }

      .signature p {
        margin: 0;
        font-size: 3mm;
        line-height: 1.4;
      }

      /* Print styles */
      @media print {
        .no-print {
          display: none !important;
        }

        body {
          background: #ffffff !important;
          margin: 0 !important;
          padding: 0 !important;
        }

        .certificates-wrapper {
          padding: 0 !important;
          gap: 0 !important;
          display: block !important;
        }

        .certificate {
          margin: 0 !important;
          box-shadow: none !important;
          width: 297mm !important;
          height: 210mm !important;
          page-break-after: always !important;
          break-after: page !important;
        }

        .certificate:last-child {
          page-break-after: avoid !important;
          break-after: avoid !important;
        }
      }

      /* Responsive preview on smaller screens */
      @media screen and (max-width: 1200px) {
        .certificate {
          max-width: 95vw;
          height: auto;
          aspect-ratio: 297 / 210;
        }
      }
    </style>
  </head>

  <body>
    <!-- Screen-Only Floating Action Toolbar -->
    <div class="no-print">
      <div class="toolbar-left">
        <a href="{{ route('admin.register.index') }}" class="btn btn-secondary">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
          <span>Back to Registrations</span>
        </a>

        <span class="badge">
          {{ $registrations->count() }} Student {{ Str::plural('Certificate', $registrations->count()) }} Selected
        </span>
      </div>

      <div class="toolbar-right">
        <button type="button" onclick="window.print()" class="btn btn-primary">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 9V2h12v7M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
          <span>Print {{ $registrations->count() > 1 ? 'All Certificates (' . $registrations->count() . ')' : 'Certificate' }}</span>
        </button>
      </div>
    </div>

    <!-- Certificates Container for Multiple or Single Print -->
    <div class="certificates-wrapper">
      @forelse($registrations as $registration)
        <div class="certificate">
          <!-- Organization logos -->
          <img
            src="{{ asset('images/intsource_logo.png') }}"
            class="company-logo"
            alt="Intsource Tech Pvt Ltd"
          />

          <img
            src="{{ asset('images/aishwarya_logo.png') }}"
            class="college-logo"
            alt="Aishwarya College Jodhpur"
          />

          <!-- Certificate title -->
          <div class="heading">
            <h1>CERTIFICATE</h1>
            <div class="subtitle">OF COMPLETION</div>
          </div>

          <!-- Student name -->
          <div class="presented">This is to certify that</div>

          <div class="student-name">
            {{ $registration->student_name ?? 'Student Name' }} {{ $registration->gender == "Female" ? "D/o" : "S/o" }} Mr. {{ $registration->father_name }}
          </div>

          <!-- Course details -->
          <div class="completion">
            <p>
              has successfully completed the
              <strong>{{ $registration->course ?? '21 Days of Basics of MERN Full Stack' }}</strong>
            </p>

            <p>Training has been conducted between</p>

            <p class="training-partners">
              Intsource Tech Pvt Ltd and Aishwarya College, Jodhpur.
            </p>
          </div>

          <div class="description">
            During this training period, the student has gained practical knowledge
            and hands-on experience in modern web development technologies and
            development practices.
          </div>

          <!-- Three authorized signatures -->
          <div class="signatures">
            <div class="signature">
              <img src="{{ asset('images/sign1.png') }}" alt="CEO signature" />
              <div class="line"></div>
              <div class="name">Bhumit Kumar</div>
              <p>Intsource Tech Pvt Ltd</p>
              <h3>CEO & Founder</h3>
            </div>

            <div class="signature">
              <img src="{{ asset('images/sign2.png') }}" alt="Principal signature" />
              <div class="line"></div>
              <div class="name">Dr. Rishi Nepaliya</div>
              <p>Aishwarya College, Jodhpur</p>
              <h3>Principal</h3>
            </div>

            <div class="signature">
              <img src="{{ asset('images/sign3.png') }}" alt="Co-ordinator signature" />
              <div class="line"></div>
              <div class="name">Joseph Dickenson</div>
              <p>Aishwarya College, Jodhpur</p>
              <h3>Internship Co-ordinator</h3>
            </div>
          </div>
        </div>
      @empty
        <div style="padding: 60px; text-align: center; color: #94a3b8;">
          <p style="font-size: 16px;">No student certificates selected.</p>
          <a href="{{ route('admin.register.index') }}" style="color: #f59e0b; margin-top: 10px; display: inline-block;">Return to Registrations</a>
        </div>
      @endforelse
    </div>
  </body>
</html>
