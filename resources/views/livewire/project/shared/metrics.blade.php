<div>
    <div class="flex items-center gap-2">
        <h2>Метрики</h2>
    </div>
    <div class="pb-4">Основні метрики для контейнера вашого застосунку.</div>
    <div>
        @if ($resource->getMorphClass() === 'App\Models\Application' && $resource->build_pack === 'dockercompose')
            <div class="alert alert-warning">Метрики поки що недоступні для застосунків Docker Compose!</div>
        @elseif(!$resource->destination->server->isMetricsEnabled())
            <div class="alert alert-warning">Метрики доступні лише для серверів із увімкненими Sentinel та Метриками!</div>
            <div>Перейдіть до <a class="underline dark:text-white" href="{{ route('server.show', $resource->destination->server->uuid) }}">Налаштування сервера</a>, щоб увімкнути їх.</div>
        @else
            @if (!str($resource->status)->contains('running'))
                <div class="alert alert-warning">Метрики доступні лише тоді, коли контейнер застосунку працює!</div>
            @else
                <div>
                <x-forms.select label="Інтервал" wire:change="setInterval" id="interval">
                <option value="5">5 хвилин (онлайн)</option>
                <option value="10">10 хвилин (онлайн)</option>
                <option value="30">30 хвилин</option>
                <option value="60">1 година</option>
                <option value="720">12 годин</option>
                <option value="10080">1 тиждень</option>
                <option value="43200">30 днів</option>
            </x-forms.select>
            <div @if ($poll) wire:poll.5000ms='pollData' @endif x-init="$wire.loadData()"
                class="pt-5">
                <h4>Використання ЦП</h4>
                <div wire:ignore id="{!! $chartId !!}-cpu"></div>

                <script>
                    checkTheme();
                    const optionsServerCpu = {
                        stroke: {
                            curve: 'straight',
                            width: 2,
                        },
                        chart: {
                            height: '150px',
                            id: '{!! $chartId !!}-cpu',
                            type: 'area',
                            toolbar: {
                                show: true,
                                tools: {
                                    download: false,
                                    selection: false,
                                    zoom: true,
                                    zoomin: false,
                                    zoomout: false,
                                    pan: false,
                                    reset: true
                                },
                            },
                            animations: {
                                enabled: true,
                            },
                        },
                        fill: {
                            type: 'gradient',
                        },
                        dataLabels: {
                            enabled: false,
                            offsetY: -10,
                            style: {
                                colors: ['#FCD452'],
                            },
                            background: {
                                enabled: false,
                            }
                        },
                         grid: {
                             show: true,
                             borderColor: '',
                         },
                         colors: [cpuColor],
                         xaxis: {
                             type: 'datetime',
                         },
                          series: [{
                              name: "ЦП %",
                             data: []
                         }],
                         noData: {
                             text: 'Завантаження...',
                             style: {
                                 color: textColor,
                             }
                         },
                         tooltip: {
                             enabled: true,
                             marker: {
                                 show: false,
                             },
                             custom: function({ series, seriesIndex, dataPointIndex, w }) {
                                 const value = series[seriesIndex][dataPointIndex];
                                 const timestamp = w.globals.seriesX[seriesIndex][dataPointIndex];
                                 const date = new Date(timestamp);
                                 const timeString = String(date.getUTCHours()).padStart(2, '0') + ':' +
                                     String(date.getUTCMinutes()).padStart(2, '0') + ':' +
                                     String(date.getUTCSeconds()).padStart(2, '0') + ', ' +
                                     date.getUTCFullYear() + '-' +
                                     String(date.getUTCMonth() + 1).padStart(2, '0') + '-' +
                                     String(date.getUTCDate()).padStart(2, '0');
                                 return '<div class="apexcharts-tooltip-custom">' +
                                     '<div class="apexcharts-tooltip-custom-value">ЦП: <span class="apexcharts-tooltip-value-bold">' + value + '%</span></div>' +
                                     '<div class="apexcharts-tooltip-custom-title">' + timeString + '</div>' +
                                     '</div>';
                             }
                         },
                         legend: {
                             show: false
                         }
                    }
                     const serverCpuChart = new ApexCharts(document.getElementById(`{!! $chartId !!}-cpu`), optionsServerCpu);
                     serverCpuChart.render();
                     Livewire.on('refreshChartData-{!! $chartId !!}-cpu', (chartData) => {
                         checkTheme();
                          serverCpuChart.updateOptions({
                              series: [{
                                  data: chartData[0].seriesData,
                              }],
                              colors: [cpuColor],
                             xaxis: {
                                 type: 'datetime',
                                 labels: {
                                     show: true,
                                     style: {
                                         colors: textColor,
                                     }
                                 }
                             },
                              yaxis: {
                                  show: true,
                                  labels: {
                                      show: true,
                                      style: {
                                          colors: textColor,
                                      },
                                      formatter: function(value) {
                                          return Math.round(value) + ' %';
                                      }
                                  }
                              },
                             noData: {
                                 text: 'Завантаження...',
                                 style: {
                                     color: textColor,
                                 }
                             }
                         });
                     });
                </script>

                <h4>Використання пам'яті</h4>
                <div wire:ignore id="{!! $chartId !!}-memory"></div>

                <script>
                    checkTheme();
                    const optionsServerMemory = {
                        stroke: {
                            curve: 'straight',
                            width: 2,
                        },
                        chart: {
                            height: '150px',
                            id: '{!! $chartId !!}-memory',
                            type: 'area',
                            toolbar: {
                                show: true,
                                tools: {
                                    download: false,
                                    selection: false,
                                    zoom: true,
                                    zoomin: false,
                                    zoomout: false,
                                    pan: false,
                                    reset: true
                                },
                            },
                            animations: {
                                enabled: true,
                            },
                        },
                        fill: {
                            type: 'gradient',
                        },
                        dataLabels: {
                            enabled: false,
                            offsetY: -10,
                            style: {
                                colors: ['#FCD452'],
                            },
                            background: {
                                enabled: false,
                            }
                        },
                         grid: {
                             show: true,
                             borderColor: '',
                         },
                         colors: [ramColor],
                         xaxis: {
                             type: 'datetime',
                             labels: {
                                 show: true,
                                 style: {
                                     colors: textColor,
                                 }
                             }
                         },
                         series: [{
                             name: "Пам'ять (МБ)",
                             data: []
                         }],
                         noData: {
                             text: 'Завантаження...',
                             style: {
                                 color: textColor,
                             }
                         },
                         tooltip: {
                             enabled: true,
                             marker: {
                                 show: false,
                             },
                             custom: function({ series, seriesIndex, dataPointIndex, w }) {
                                 const value = series[seriesIndex][dataPointIndex];
                                 const timestamp = w.globals.seriesX[seriesIndex][dataPointIndex];
                                 const date = new Date(timestamp);
                                 const timeString = String(date.getUTCHours()).padStart(2, '0') + ':' +
                                     String(date.getUTCMinutes()).padStart(2, '0') + ':' +
                                     String(date.getUTCSeconds()).padStart(2, '0') + ', ' +
                                     date.getUTCFullYear() + '-' +
                                     String(date.getUTCMonth() + 1).padStart(2, '0') + '-' +
                                     String(date.getUTCDate()).padStart(2, '0');
                                 return '<div class="apexcharts-tooltip-custom">' +
                                     '<div class="apexcharts-tooltip-custom-value">Пам\'ять: <span class="apexcharts-tooltip-value-bold">' + value + ' МБ</span></div>' +
                                     '<div class="apexcharts-tooltip-custom-title">' + timeString + '</div>' +
                                     '</div>';
                             }
                         },
                         legend: {
                             show: false
                         }
                    }
                     const serverMemoryChart = new ApexCharts(document.getElementById(`{!! $chartId !!}-memory`),
                         optionsServerMemory);
                     serverMemoryChart.render();
                     Livewire.on('refreshChartData-{!! $chartId !!}-memory', (chartData) => {
                         checkTheme();
                          serverMemoryChart.updateOptions({
                              series: [{
                                  data: chartData[0].seriesData,
                              }],
                              colors: [ramColor],
                             xaxis: {
                                 type: 'datetime',
                                 labels: {
                                     show: true,
                                     style: {
                                         colors: textColor,
                                     }
                                 }
                             },
                              yaxis: {
                                  min: 0,
                                  show: true,
                                  labels: {
                                      show: true,
                                      style: {
                                          colors: textColor,
                                      },
                                      formatter: function(value) {
                                          return Math.round(value) + ' MB';
                                      }
                                  }
                              },
                             noData: {
                                 text: 'Завантаження...',
                                 style: {
                                     color: textColor,
                                 }
                             }
                         });
                     });
                </script>
            </div>
            </div>
        @endif
    @endif
    </div>
</div>