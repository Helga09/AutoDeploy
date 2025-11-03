<div class="flex flex-col gap-2">
    <div class="flex items-center gap-2">
        <h2>Вебхуки</h2>
        <x-helper
            helper="Для отримання додаткової інформації перейдіть до нашої <a class='underline dark:text-white' href='https://coolify.io/docs/api/operations/deploy-by-tag-or-uuid' target='_blank'>документації</a>." />
    </div>
    <div>
        <x-forms.input readonly
            helper="Дивіться деталі в нашій <a target='_blank' class='underline dark:text-white' href='https://coolify.io/docs/api/operations/deploy-by-tag-or-uuid'>документації</a>."
            label="Вебхук розгортання (потрібна автентифікація)" id="deploywebhook"></x-forms.input>
    </div>
    @if ($resource->type() === 'application')
        <div>
            <h3>Вебхуки Git вручну</h3>
            @if ($githubManualWebhook && $gitlabManualWebhook)
                <form wire:submit='submit' class="flex flex-col gap-2">
                    <div class="flex items-end gap-2">
                        <x-forms.input helper="Тип контенту в конфігурації GitHub може бути json або form-urlencoded."
                            readonly label="GitHub" id="githubManualWebhook"></x-forms.input>
                        @can('update', $resource)
                            <x-forms.input type="password"
                                helper="Потрібно встановити секрет, щоб використовувати цей вебхук. Він має збігатися з секретом у GitHub."
                                label="Секрет вебхука GitHub" id="githubManualWebhookSecret"></x-forms.input>
                        @else
                            <x-forms.input disabled type="password"
                                helper="Потрібно встановити секрет, щоб використовувати цей вебхук. Він має збігатися з секретом у GitHub."
                                label="Секрет вебхука GitHub" id="githubManualWebhookSecret"></x-forms.input>
                        @endcan
                    </div>
                    <a target="_blank" class="flex hover:no-underline" href="{{ $resource?->gitWebhook }}">
                        <x-forms.button>Конфігурація вебхука на GitHub
                            <x-external-link />
                        </x-forms.button>
                    </a>
                    <div class="flex gap-2">
                        <x-forms.input readonly label="GitLab" id="gitlabManualWebhook"></x-forms.input>
                        @can('update', $resource)
                            <x-forms.input type="password"
                                helper="Потрібно встановити секрет, щоб використовувати цей вебхук. Він має збігатися з секретом у GitLab."
                                label="Секрет вебхука GitLab" id="gitlabManualWebhookSecret"></x-forms.input>
                        @else
                            <x-forms.input disabled type="password"
                                helper="Потрібно встановити секрет, щоб використовувати цей вебхук. Він має збігатися з секретом у GitLab."
                                label="Секрет вебхука GitLab" id="gitlabManualWebhookSecret"></x-forms.input>
                        @endcan
                    </div>
                    <div class="flex gap-2">
                        <x-forms.input readonly label="Bitbucket" id="bitbucketManualWebhook"></x-forms.input>
                        @can('update', $resource)
                            <x-forms.input type="password"
                                helper="Потрібно встановити секрет, щоб використовувати цей вебхук. Він має збігатися з секретом у Bitbucket."
                                label="Секрет вебхука Bitbucket" id="bitbucketManualWebhookSecret"></x-forms.input>
                        @else
                            <x-forms.input disabled type="password"
                                helper="Потрібно встановити секрет, щоб використовувати цей вебхук. Він має збігатися з секретом у Bitbucket."
                                label="Секрет вебхука Bitbucket" id="bitbucketManualWebhookSecret"></x-forms.input>
                        @endcan
                    </div>
                    <div class="flex gap-2">
                        <x-forms.input readonly label="Gitea" id="giteaManualWebhook"></x-forms.input>
                        @can('update', $resource)
                            <x-forms.input type="password"
                                helper="Потрібно встановити секрет, щоб використовувати цей вебхук. Він має збігатися з секретом у Gitea."
                                label="Секрет вебхука Gitea" id="giteaManualWebhookSecret"></x-forms.input>
                        @else
                            <x-forms.input disabled type="password"
                                helper="Потрібно встановити секрет, щоб використовувати цей вебхук. Він має збігатися з секретом у Gitea."
                                label="Секрет вебхука Gitea" id="giteaManualWebhookSecret"></x-forms.input>
                        @endcan
                    </div>
                    @can('update', $resource)
                        <x-forms.button type="submit">Зберегти</x-forms.button>
                    @endcan
                </form>
            @else
                <x-callout type="info" title="Інформація">
                    Ви використовуєте офіційний застосунок Git. Вам не потрібні вебхуки вручну.
                </x-callout>
            @endif
        </div>
    @endif

</div>