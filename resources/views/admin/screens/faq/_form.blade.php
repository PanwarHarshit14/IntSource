<div class="space-y-6">
    <!-- Question Field -->
    <div>
        <label for="question" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-slate-300">
            FAQ Question <span class="text-rose-400">*</span>
        </label>
        <div class="relative">
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-500">
                <i class="ri-questionnaire-line text-base"></i>
            </span>
            <input type="text"
                   name="question"
                   id="question"
                   value="{{ old('question', $faq->question ?? '') }}"
                   required
                   autofocus
                   placeholder="e.g. What is the typical turnaround time for a project?"
                   class="w-full rounded-xl border border-slate-700/80 bg-[#0A0D14] py-3 pl-10 pr-4 text-sm text-white placeholder-slate-500 transition duration-200 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20">
        </div>
        <p class="mt-1.5 text-xs text-slate-500">Keep questions concise and phrased from a customer's perspective.</p>
    </div>

    <!-- Answer Field -->
    <div>
        <label for="answer" class="mb-2 block text-xs font-semibold uppercase tracking-wider text-slate-300">
            Answer Content <span class="text-rose-400">*</span>
        </label>
        <div class="relative">
            <textarea name="answer"
                      id="answer"
                      rows="6"
                      required
                      placeholder="Write a clear, helpful explanation..."
                      class="w-full rounded-xl border border-slate-700/80 bg-[#0A0D14] p-4 text-sm leading-relaxed text-white placeholder-slate-500 transition duration-200 outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20">{{ old('answer', $faq->answer ?? '') }}</textarea>
        </div>
        <p class="mt-1.5 text-xs text-slate-500">HTML or plain text are supported. Be informative, transparent, and direct.</p>
    </div>
</div>