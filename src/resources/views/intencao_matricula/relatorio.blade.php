@extends('layouts.main')

@section('title', 'Relatório de Intenção de Matrícula')

@section('content')
<div class="page-header">
    <div class="container">
        <div class="title-container">
            <div class="page-title">
                <i class="fas fa-chart-bar fa-2x"></i>
                <h2>Relatório de Intenção de Matrícula</h2>
            </div>
        </div>
    </div>
</div>

<div class="container mt-3">
    <div class="content-card mb-4">
        <div class="card-header">
            <span>Informações da Intenção</span>
            <a href="{{ route('intencao_matricula.index') }}" class="btn-voltar">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
        </div>
        <div class="card-body p-3">
            <div class="row">
                <div class="col-md-6">
                    <div class="info-summary mb-3">
                        <h5><i class="fas fa-calendar-alt me-2"></i>Semestre e Ano</h5>
                        <div class="d-flex justify-content-around mt-3">
                            <div class="text-center">
                                <span class="d-block info-value">{{ $intencao_matricula->numero_periodo }}º</span>
                                <small class="text-muted">Semestre</small>
                            </div>
                            <div class="text-center">
                                <span class="d-block info-value">{{ $intencao_matricula->ano }}</span>
                                <small class="text-muted">Ano</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-summary mb-3">
                        <h5><i class="fas fa-users me-2"></i>Estatísticas</h5>
                        <div class="d-flex justify-content-around mt-3">
                            <div class="text-center">
                                <span class="d-block info-value">{{ $intencao_matricula->disciplinas->count() }}</span>
                                <small class="text-muted">Disciplinas</small>
                            </div>
                            <div class="text-center">
                                <span class="d-block info-value">{{ $totalAlunos }}</span>
                                <small class="text-muted">Alunos Respondentes</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-card mb-4">
        <div class="card-header">
            <span>Disciplinas Escolhidas</span>
            <div class="dropdown">
                <button class="btn btn-outline-light btn-sm dropdown-toggle" type="button" id="chartTypeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-chart-bar me-1"></i> Tipo de Gráfico
                </button>
                <ul class="dropdown-menu" aria-labelledby="chartTypeDropdown">
                    <li><a class="dropdown-item chart-type active" data-type="bar" href="#"><i class="fas fa-chart-bar me-2"></i>Gráfico de Barras</a></li>
                    <li><a class="dropdown-item chart-type" data-type="pie" href="#"><i class="fas fa-chart-pie me-2"></i>Gráfico de Pizza</a></li>
                    <li><a class="dropdown-item chart-type" data-type="doughnut" href="#"><i class="fas fa-circle-notch me-2"></i>Gráfico de Rosca</a></li>
                </ul>
            </div>
        </div>
        <div class="card-body p-3">
            @if($totalAlunos == 0)
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-2x mb-3 d-block"></i>
                    <h5>Nenhum aluno respondeu a esta intenção de matrícula ainda.</h5>
                    <p class="mb-0">Os dados serão apresentados assim que os alunos começarem a responder.</p>
                </div>
            @else
                <div class="row">
                    <div class="col-md-8">
                        <div class="chart-container p-3 rounded" style="position: relative; height:400px;">
                            <canvas id="disciplinasChart"></canvas>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0">
                            <div class="card-header text-white div-form">
                                <i class="fas fa-table me-2"></i>Distribuição de Escolhas
                            </div>
                            <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
                                <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Disciplina</th>
                                            <th class="text-center">Qtd</th>
                                            <th class="text-center">%</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($disciplinasEscolhidas as $disciplina)
                                        <tr>
                                            <td>{{ $disciplina['nome'] }}</td>
                                            <td class="text-center"><span class="badge bg-primary">{{ $disciplina['count'] }}</span></td>
                                            <td class="text-center">
                                                <div class="progress" style="height: 20px;">
                                                    <div class="progress-bar" role="progressbar" style="width: {{ $disciplina['percentage'] }}%;" 
                                                        aria-valuenow="{{ $disciplina['percentage'] }}" aria-valuemin="0" aria-valuemax="100">
                                                        {{ $disciplina['percentage'] }}%
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if($totalAlunos > 0)
    <div class="content-card mb-4">
        <div class="card-header">
            <span>Disciplinas Escolhidas por Período</span>
            <div class="dropdown">
                <button class="btn btn-outline-light btn-sm dropdown-toggle" type="button" id="periodChartTypeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-chart-bar me-1"></i> Tipo de Gráfico
                </button>
                <ul class="dropdown-menu" aria-labelledby="periodChartTypeDropdown">
                    <li><a class="dropdown-item period-chart-type" data-type="bar" href="#"><i class="fas fa-chart-bar me-2"></i>Gráfico de Barras</a></li>
                    <li><a class="dropdown-item period-chart-type" data-type="line" href="#"><i class="fas fa-chart-line me-2"></i>Gráfico de Linha</a></li>
                    <li><a class="dropdown-item period-chart-type" data-type="radar" href="#"><i class="fas fa-spider me-2"></i>Gráfico de Radar</a></li>
                </ul>
            </div>
        </div>
        <div class="card-body p-3">
            <div class="chart-container p-3 rounded" style="position: relative; height:400px;">
                <canvas id="periodoChart"></canvas>
            </div>
            <div class="mt-4">
                <div class="accordion" id="accordionPeriodos">
                    @foreach($disciplinasPorPeriodo as $periodo)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $periodo['periodo'] }}" aria-expanded="false" aria-controls="collapse{{ $periodo['periodo'] }}">
                                <strong>{{ $periodo['periodo'] }}º Período</strong> <span class="badge bg-primary ms-2">{{ count($periodo['disciplinas']) }} disciplina(s)</span> <span class="badge bg-secondary ms-2">{{ $periodo['count'] }} escolha(s)</span>
                            </button>
                        </h2>
                        <div id="collapse{{ $periodo['periodo'] }}" class="accordion-collapse collapse" data-bs-parent="#accordionPeriodos">
                            <div class="accordion-body">
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>Disciplina</th>
                                                <th class="text-center">Escolhas</th>
                                                <th class="text-center">%</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($periodo['disciplinas'] as $disciplina)
                                            <tr>
                                                <td>{{ $disciplina['nome'] }}</td>
                                                <td class="text-center">{{ $disciplina['count'] }}</td>
                                                <td class="text-center">{{ $disciplina['percentage'] }}%</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <!-- Seção de Disciplinas Optativas -->
    @if(isset($disciplinasOptativas) && count($disciplinasOptativas) > 0)
    <div class="content-card mb-4">
        <div class="card-header">
            <span>Disciplinas Optativas Escolhidas</span>
            <div class="dropdown">
                <button class="btn btn-outline-light btn-sm dropdown-toggle" type="button" id="optativasChartTypeDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-chart-bar me-1"></i> Tipo de Gráfico
                </button>
                <ul class="dropdown-menu" aria-labelledby="optativasChartTypeDropdown">
                    <li><a class="dropdown-item optativas-chart-type active" data-type="bar" href="#"><i class="fas fa-chart-bar me-2"></i>Gráfico de Barras</a></li>
                    <li><a class="dropdown-item optativas-chart-type" data-type="pie" href="#"><i class="fas fa-chart-pie me-2"></i>Gráfico de Pizza</a></li>
                    <li><a class="dropdown-item optativas-chart-type" data-type="doughnut" href="#"><i class="fas fa-circle-notch me-2"></i>Gráfico de Rosca</a></li>
                </ul>
            </div>
        </div>
        <div class="card-body p-3">
            <div class="row">
                <div class="col-md-8">
                    <div class="chart-container p-3 rounded" style="position: relative; height:400px;">
                        <canvas id="optativasChart"></canvas>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="accordion" id="accordionOptativas">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOptativas" aria-expanded="true" aria-controls="collapseOptativas">
                                    <strong>Disciplinas Optativas</strong> <span class="badge bg-info ms-2">{{ count($disciplinasOptativas) }} disciplina(s)</span>
                                </button>
                            </h2>
                            <div id="collapseOptativas" class="accordion-collapse collapse show" data-bs-parent="#accordionOptativas">
                                <div class="accordion-body">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Disciplina</th>
                                                    <th class="text-center">Escolhas</th>
                                                    <th class="text-center">%</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($disciplinasOptativas as $disciplina)
                                                <tr>
                                                    <td>{{ $disciplina['nome'] }}</td>
                                                    <td class="text-center">{{ $disciplina['count'] }}</td>
                                                    <td class="text-center">{{ $disciplina['percentage'] }}%</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Se não há alunos, não tenta criar o gráfico
    if ({{ $totalAlunos }} === 0) {
        return;
    }
    
    const ctx = document.getElementById('disciplinasChart').getContext('2d');
    
    const labels = {!! json_encode(array_column($disciplinasEscolhidas, 'nome')) !!};
    const data = {!! json_encode(array_column($disciplinasEscolhidas, 'percentage')) !!};
    const counts = {!! json_encode(array_column($disciplinasEscolhidas, 'count')) !!};
    
    // Gerar cores com base no espectro de cores
    const colors = generateColors(labels.length);
    
    // Configuração do gráfico
    let chartConfig = {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Porcentagem de Escolha',
                data: data,
                backgroundColor: colors,
                borderColor: colors.map(color => color.replace('0.7', '1')),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            scales: {
                x: {
                    beginAtZero: true,
                    max: 100,
                    title: {
                        display: true,
                        text: 'Porcentagem (%)'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false,
                    labels: {
                        boxWidth: 15,
                        font: {
                            size: 12
                        },
                        generateLabels: function(chart) {
                            // Modificar as labels para incluir contagem e porcentagem
                            const datasets = chart.data.datasets;
                            const labels = chart.data.labels;
                            const counts = {!! json_encode(array_column($disciplinasEscolhidas, 'count')) !!};
                            
                            if (datasets.length === 0) return [];
                            
                            return chart._getSortedDatasetMetas().map((meta, i) => {
                                const style = meta.controller.getStyle(i);
                                return {
                                    text: `${labels[i]} (${counts[i]}, ${datasets[0].data[i]}%)`,
                                    fillStyle: style.backgroundColor,
                                    strokeStyle: style.borderColor,
                                    lineWidth: style.borderWidth,
                                    hidden: !chart.getDataVisibility(i),
                                    index: i
                                };
                            });
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const count = counts[context.dataIndex];
                            return [
                                `${label}`,
                                `Alunos: ${count} (${value}%)`
                            ];
                        }
                    }
                },
                title: {
                    display: true,
                    text: 'Distribuição de Disciplinas Escolhidas',
                    font: {
                        size: 16,
                        weight: 'bold'
                    },
                    padding: {
                        top: 10,
                        bottom: 20
                    }
                }
            }
        }
    };
    
    // Criar gráfico
    let myChart = new Chart(ctx, chartConfig);
    
    // Função para atualizar o tipo de gráfico
    document.querySelectorAll('.chart-type').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const chartType = this.getAttribute('data-type');
            
            // Atualizar classe ativa no dropdown
            document.querySelectorAll('.chart-type').forEach(btn => {
                btn.classList.remove('active');
            });
            this.classList.add('active');
            
            // Destruir gráfico existente
            myChart.destroy();
            
            // Atualizar configuração
            chartConfig.type = chartType;
            
            // Ajustes específicos para cada tipo de gráfico
            if (chartType === 'bar') {
                // Configuração para gráfico de barras
                chartConfig.options.indexAxis = 'y';
                chartConfig.options.scales = {
                    x: {
                        beginAtZero: true,
                        max: 100,
                        title: {
                            display: true,
                            text: 'Porcentagem (%)'
                        }
                    }
                };
                chartConfig.options.plugins.legend.display = false;
            } else {
                // Configuração para gráficos de pizza/rosca
                delete chartConfig.options.indexAxis;
                delete chartConfig.options.scales;
                chartConfig.options.plugins.legend.display = true;
                chartConfig.options.plugins.legend.position = 'right';
            }
            
            // Recriar gráfico
            myChart = new Chart(ctx, chartConfig);
        });
    });
    
    // Configuração do gráfico por período
    if ({{ $totalAlunos }} > 0) {
        const ctxPeriodo = document.getElementById('periodoChart').getContext('2d');
        
        // Extrair dados dos períodos
        const periodoData = {!! json_encode($disciplinasPorPeriodo) !!};
        
        // Adicionar debug para verificar os dados (remover após debug)
        console.log('Dados por período:', periodoData);
        
        // Verificar se temos dados
        if (periodoData && periodoData.length > 0) {
            const periodoLabels = periodoData.map(p => `${p.periodo}º Período`);
            const periodoCounts = periodoData.map(p => p.count);
            
            // Criar cores diferentes para cada período
            const periodoColors = generateColors(periodoData.length);
            
            // Configuração do gráfico de períodos
            let periodoChartConfig = {
                type: 'bar',
                data: {
                    labels: periodoLabels,
                    datasets: [{
                        label: 'Total de Escolhas',
                        data: periodoCounts,
                        backgroundColor: periodoColors,
                        borderColor: periodoColors.map(color => color.replace('0.7', '1')),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Número de Escolhas'
                            }
                        }
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: 'Distribuição de Escolhas por Período',
                            font: {
                                size: 16,
                                weight: 'bold'
                            },
                            padding: {
                                top: 10,
                                bottom: 20
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const periodoInfo = periodoData[context.dataIndex];
                                    const disciplinasCount = periodoInfo.disciplinas.length;
                                    return [
                                        `Total de escolhas: ${context.raw}`,
                                        `Quantidade de disciplinas: ${disciplinasCount}`
                                    ];
                                }
                            }
                        }
                    }
                }
            };            // Criar gráfico de períodos
            let periodoChart = new Chart(ctxPeriodo, periodoChartConfig);
            
            // Função para atualizar o tipo de gráfico de períodos
            document.querySelectorAll('.period-chart-type').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const chartType = this.getAttribute('data-type');
                    
                    // Destruir gráfico existente
                    periodoChart.destroy();
                    
                    // Atualizar configuração
                    periodoChartConfig.type = chartType;
                    
                    // Ajustes específicos para cada tipo de gráfico
                    if (chartType === 'line') {
                        periodoChartConfig.data.datasets[0].fill = false;
                        periodoChartConfig.data.datasets[0].tension = 0.1;
                        periodoChartConfig.options.scales = {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Número de Escolhas'
                                }
                            }
                        };
                    } else if (chartType === 'radar') {
                        delete periodoChartConfig.options.scales;
                        periodoChartConfig.data.datasets[0].fill = true;
                    } else if (chartType === 'bar') {
                        // Reset para configuração padrão de barras
                        periodoChartConfig.options.scales = {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Número de Escolhas'
                                }
                            }
                        };
                    }
                    
                    // Recriar gráfico
                    periodoChart = new Chart(ctxPeriodo, periodoChartConfig);
                });
            });
            
            // Gráfico para disciplinas optativas
            if (document.getElementById('optativasChart')) {
                const ctxOptativas = document.getElementById('optativasChart').getContext('2d');
                
                // Verificar se temos dados de disciplinas optativas
                const disciplinasOptativas = {!! isset($disciplinasOptativas) ? json_encode($disciplinasOptativas) : '[]' !!};
                
                if (disciplinasOptativas.length > 0) {
                    const optativasLabels = disciplinasOptativas.map(d => d.nome);
                    const optativasData = disciplinasOptativas.map(d => d.percentage);
                    const optativasCounts = disciplinasOptativas.map(d => d.count);
                    
                    // Gerar cores para o gráfico
                    const optativasColors = generateColors(disciplinasOptativas.length);
                    
                    // Configuração do gráfico
                    let optativasChartConfig = {
                        type: 'bar',
                        data: {
                            labels: optativasLabels,
                            datasets: [{
                                label: 'Porcentagem de Escolha',
                                data: optativasData,
                                backgroundColor: optativasColors,
                                borderColor: optativasColors.map(color => color.replace('0.7', '1')),
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            indexAxis: 'y',
                            scales: {
                                x: {
                                    beginAtZero: true,
                                    max: 100,
                                    title: {
                                        display: true,
                                        text: 'Porcentagem (%)'
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const label = context.label || '';
                                            const value = context.raw || 0;
                                            const count = optativasCounts[context.dataIndex];
                                            return [
                                                `${label}`,
                                                `Alunos: ${count} (${value}%)`
                                            ];
                                        }
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Distribuição de Disciplinas Optativas Escolhidas',
                                    font: {
                                        size: 16,
                                        weight: 'bold'
                                    },
                                    padding: {
                                        top: 10,
                                        bottom: 20
                                    }
                                }
                            }
                        }
                    };
                    
                    // Criar gráfico
                    let optativasChart = new Chart(ctxOptativas, optativasChartConfig);
                    
                    // Função para atualizar o tipo de gráfico
                    document.querySelectorAll('.optativas-chart-type').forEach(button => {
                        button.addEventListener('click', function(e) {
                            e.preventDefault();
                            const chartType = this.getAttribute('data-type');
                            
                            // Atualizar classe ativa no dropdown
                            document.querySelectorAll('.optativas-chart-type').forEach(btn => {
                                btn.classList.remove('active');
                            });
                            this.classList.add('active');
                            
                            // Destruir gráfico existente
                            optativasChart.destroy();
                            
                            // Atualizar configuração
                            optativasChartConfig.type = chartType;
                            
                            // Ajustes específicos para cada tipo de gráfico
                            if (chartType === 'bar') {
                                // Configuração para gráfico de barras
                                optativasChartConfig.options.indexAxis = 'y';
                                optativasChartConfig.options.scales = {
                                    x: {
                                        beginAtZero: true,
                                        max: 100,
                                        title: {
                                            display: true,
                                            text: 'Porcentagem (%)'
                                        }
                                    }
                                };
                                optativasChartConfig.options.plugins.legend.display = false;
                            } else {
                                // Configuração para gráficos de pizza/rosca
                                delete optativasChartConfig.options.indexAxis;
                                delete optativasChartConfig.options.scales;
                                optativasChartConfig.options.plugins.legend.display = true;
                                optativasChartConfig.options.plugins.legend.position = 'right';
                            }
                            
                            // Recriar gráfico
                            optativasChart = new Chart(ctxOptativas, optativasChartConfig);
                        });
                    });
                }
            }
        } else {
            // Se não houver dados para períodos, exibir mensagem
            const periodoContainer = document.querySelector('#periodoChart').parentNode;
            periodoContainer.innerHTML = `
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-2x mb-3 d-block"></i>
                    <h5>Não há dados suficientes para exibir o gráfico por período.</h5>
                    <p class="mb-0">Certifique-se de que existem disciplinas com diferentes períodos e que foram escolhidas pelos alunos.</p>
                </div>
            `;
        }
    }
    
    // Função para gerar cores aleatórias
    function generateColors(count) {
        const colors = [];
        const baseColors = [
            'hsla(211, 70%, 30%, 0.7)',  // Azul escuro (primary-blue)
            'hsla(211, 55%, 50%, 0.7)',  // Azul médio (secondary-blue)
            'hsla(210, 50%, 60%, 0.7)',  // Azul claro (light-blue)
            'hsla(134, 61%, 41%, 0.7)',  // Verde (accent-green)
            'hsla(0, 70%, 60%, 0.7)',    // Vermelho
            'hsla(275, 70%, 60%, 0.7)',  // Roxo
            'hsla(30, 90%, 50%, 0.7)',   // Laranja
            'hsla(180, 70%, 50%, 0.7)',  // Ciano
            'hsla(330, 80%, 60%, 0.7)',  // Rosa
            'hsla(150, 60%, 50%, 0.7)'   // Verde-água
        ];
        
        for (let i = 0; i < count; i++) {
            if (i < baseColors.length) {
                colors.push(baseColors[i]);
            } else {
                const hue = (i * 137) % 360; // Espaçamento de cor para evitar cores próximas
                colors.push(`hsla(${hue}, 70%, 50%, 0.7)`);
            }
        }
        return colors;
    }
});
</script>

<style>
.chart-container {
    margin: 0 auto;
    box-shadow: var(--shadow-md);
    transition: var(--transition-normal);
    border: 1px solid rgba(0,0,0,0.1);
}

.chart-container:hover {
    box-shadow: var(--shadow-lg);
}

.info-summary {
    border-left: 4px solid var(--secondary-blue);
    padding: 15px;
    background-color: #f8f9fa;
    border-radius: 5px;
    transition: var(--transition-normal);
}

.info-summary:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
}

.info-value {
    font-size: 2rem;
    font-weight: bold;
    color: var(--primary-blue);
}

.progress {
    background-color: #eaecf4;
    box-shadow: inset 0 0.1rem 0.1rem rgba(0,0,0,0.1);
}

.progress-bar {
    background-color: var(--secondary-blue);
    transition: width 1s ease-in-out;
}

.btn-voltar {
    color: white;
    background-color: transparent;
    border: 1px solid rgba(255,255,255,0.3);
    padding: 0.375rem 0.75rem;
    border-radius: 0.35rem;
    transition: var(--transition-normal);
    text-decoration: none;
}

.btn-voltar:hover {
    color: white;
    background-color: rgba(255,255,255,0.1);
    border-color: rgba(255,255,255,0.5);
}

.table thead th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #e3e6f0;
}

.badge {
    font-size: 0.85rem;
    padding: 0.35em 0.65em;
}

.div-form {
    background-color: var(--primary-blue);
    color: white;
}

/* Estilo para dropdown de tipo de gráfico */
.dropdown-item.active, 
.dropdown-item:active {
    background-color: rgba(28, 44, 76, 0.8);
    color: white;
}

/* Acordeão de períodos */
.accordion-button:not(.collapsed) {
    background-color: rgba(28, 44, 76, 0.1);
    color: var(--primary-blue);
}

.accordion-button:focus {
    box-shadow: 0 0 0 0.25rem rgba(28, 44, 76, 0.25);
}

.accordion-item {
    border-color: rgba(28, 44, 76, 0.2);
}

/* Responsividade */
@media (max-width: 768px) {
    .chart-container {
        height: 300px !important;
    }
    
    .info-value {
        font-size: 1.8rem;
    }
}

/* Estilo para impressão */
@media print {
    .dropdown {
        display: none !important;
    }
    
    .container {
        width: 100%;
        max-width: 100%;
    }
    
    .content-card {
        break-inside: avoid;
        page-break-inside: avoid;
        margin-bottom: 20px;
    }
    
    .chart-container {
        height: 350px !important;
    }
}
</style>
@stop
