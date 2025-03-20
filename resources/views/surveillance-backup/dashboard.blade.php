<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord Surveillance') }}
        </h2>
    </x-slot>

    <!-- Ajout des styles Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 800px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        
        .form-title {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }
        
        .form-section-title {
            font-weight: bold;
            font-size: 1.2rem;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        
        .service-options {
            padding-left: 25px;
            margin-bottom: 15px;
        }
        
        .navbar {
            background-color: #4f46e5;
            margin-bottom: 20px;
        }
        
        footer {
            background-color: #f8f9fa;
            padding: 15px 0;
            text-align: center;
            margin-top: 30px;
            color: #6c757d;
        }
    </style>

    <div class="container form-container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="form-title mb-0">Formulaire</h1>
            <a href="{{ route('surveillance.orders') }}" class="btn btn-primary">
                <i class="bi bi-clock-history"></i> Voir mes commandes
            </a>
        </div>
        
        @if (session('success'))
            <div class="alert alert-success mb-4">
                <strong>Succès!</strong>
                <span>{{ session('success') }}</span>
            </div>
        @endif
        
        <form id="serviceForm" method="POST" action="{{ route('surveillance.submit-form') }}">
            @csrf
            
            <!-- Informations personnelles -->
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="nom" class="form-label">Nom Complet</label>
                    <input type="text" class="form-control" id="nom" name="nom" required>
                    @error('nom')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="tel" class="form-label">N° Tel</label>
                    <input type="tel" class="form-control" id="tel" name="tel" required>
                    @error('tel')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="ville" class="form-label">Ville</label>
                    <select class="form-select" id="ville" name="ville" required>
                        <option value="" selected disabled>sélectionnez une ville</option>
                        <option value="casablanca">Casablanca</option>
                        <option value="rabat">Rabat</option>
                        <option value="marrakech">Marrakech</option>
                        <option value="tanger">Tanger</option>
                        <option value="fes">Fès</option>
                        <option value="agadir">Agadir</option>
                    </select>
                    @error('ville')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-12">
                    <label for="entreprise" class="form-label">Nom d'entreprise :</label>
                    <input type="text" class="form-control" id="entreprise" name="entreprise" required>
                    @error('entreprise')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <!-- Sélection des services -->
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="form-section-title">Les Services choisi :</div>
                    
                    <!-- Création web et mobile -->
                    <div class="form-check mb-2">
                        <input class="form-check-input category-checkbox" type="checkbox" id="web_mobile" name="services[]" value="web_mobile" data-category="web_mobile">
                        <label class="form-check-label" for="web_mobile">
                            Création web et mobile
                        </label>
                    </div>
                    
                    <!-- Options pour Création web uniquement -->
                    <div class="service-options" id="web_mobile_options" style="display: none;">
                        <div class="form-check">
                            <input class="form-check-input service-radio" type="radio" name="web_mobile_option" id="site_base" value="site_base" data-price="3500">
                            <label class="form-check-label" for="site_base">
                                Site web de base <span class="text-secondary">3500 MAD</span>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input service-radio" type="radio" name="web_mobile_option" id="site_pro" value="site_pro" data-price="7500">
                            <label class="form-check-label" for="site_pro">
                                Site web professionnel <span class="text-secondary">7500 MAD</span>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input service-radio" type="radio" name="web_mobile_option" id="site_ecom" value="site_ecom" data-price="12000">
                            <label class="form-check-label" for="site_ecom">
                                Site web E-commerce <span class="text-secondary">12000 MAD</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Télémarketing -->
                    <div class="form-check mb-2">
                        <input class="form-check-input category-checkbox" type="checkbox" id="telemarketing" name="services[]" value="telemarketing" data-category="telemarketing">
                        <label class="form-check-label" for="telemarketing">
                            Télémarketing
                        </label>
                    </div>
                    
                    <!-- Options pour Télémarketing -->
                    <div class="service-options" id="telemarketing_options" style="display: none;">
                        <div class="form-check">
                            <input class="form-check-input service-radio" type="radio" name="telemarketing_option" id="support_client" value="support_client" data-price="5000">
                            <label class="form-check-label" for="support_client">
                                Forfait de Support Client Téléphonique <span class="text-secondary">5000 MAD</span>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input service-radio" type="radio" name="telemarketing_option" id="generation_leads" value="generation_leads" data-price="7000">
                            <label class="form-check-label" for="generation_leads">
                                Forfait de Génération de Leads <span class="text-secondary">7000 MAD</span>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input service-radio" type="radio" name="telemarketing_option" id="vente_tel" value="vente_tel" data-price="6000">
                            <label class="form-check-label" for="vente_tel">
                                Forfait de Vente Téléphonique <span class="text-secondary">6000 MAD</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- SEO -->
                    <div class="form-check mb-2">
                        <input class="form-check-input category-checkbox" type="checkbox" id="seo" name="services[]" value="seo" data-category="seo">
                        <label class="form-check-label" for="seo">
                            SEO
                        </label>
                    </div>
                    
                    <!-- Options pour SEO -->
                    <div class="service-options" id="seo_options" style="display: none;">
                        <div class="form-check">
                            <input class="form-check-input service-radio" type="radio" name="seo_option" id="seo_base" value="seo_base" data-price="2500">
                            <label class="form-check-label" for="seo_base">
                                Site Web de Base <span class="text-secondary">2500 MAD</span>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input service-radio" type="radio" name="seo_option" id="seo_pro" value="seo_pro" data-price="4500">
                            <label class="form-check-label" for="seo_pro">
                                Site Web Professionnel <span class="text-secondary">4500 MAD</span>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input service-radio" type="radio" name="seo_option" id="seo_ecom" value="seo_ecom" data-price="6500">
                            <label class="form-check-label" for="seo_ecom">
                                Site Web E-commerce <span class="text-secondary">6500 MAD</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Digital Marketing -->
                    <div class="form-check mb-2">
                        <input class="form-check-input category-checkbox" type="checkbox" id="digital_marketing" name="services[]" value="digital_marketing" data-category="digital_marketing">
                        <label class="form-check-label" for="digital_marketing">
                            Digital Marketing
                        </label>
                    </div>
                    
                    <!-- Options pour Digital Marketing -->
                    <div class="service-options" id="digital_marketing_options" style="display: none;">
                        <div class="form-check">
                            <input class="form-check-input service-radio" type="radio" name="digital_marketing_option" id="pub_ligne" value="pub_ligne" data-price="3000">
                            <label class="form-check-label" for="pub_ligne">
                                Publicité en Ligne <span class="text-secondary">3000 MAD</span>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input service-radio" type="radio" name="digital_marketing_option" id="marketing_influence" value="marketing_influence" data-price="4000">
                            <label class="form-check-label" for="marketing_influence">
                                Marketing d'Influence <span class="text-secondary">4000 MAD</span>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input service-radio" type="radio" name="digital_marketing_option" id="marketing_social" value="marketing_social" data-price="2500">
                            <label class="form-check-label" for="marketing_social">
                                Marketing des Médias Sociaux <span class="text-secondary">2500 MAD</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Conception et impression -->
                    <div class="form-check mb-2">
                        <input class="form-check-input category-checkbox" type="checkbox" id="conception" name="services[]" value="conception" data-category="conception">
                        <label class="form-check-label" for="conception">
                            Conception et impression
                        </label>
                    </div>
                    
                    <!-- Options pour Conception et impression -->
                    <div class="service-options" id="conception_options" style="display: none;">
                        <div class="form-check">
                            <input class="form-check-input service-radio" type="radio" name="conception_option" id="standard_essentiel" value="standard_essentiel" data-price="1500">
                            <label class="form-check-label" for="standard_essentiel">
                                Standard- Essentiel <span class="text-secondary">1500 MAD</span>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input service-radio" type="radio" name="conception_option" id="professionnelle" value="professionnelle" data-price="3000">
                            <label class="form-check-label" for="professionnelle">
                                Professionnelle <span class="text-secondary">3000 MAD</span>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input service-radio" type="radio" name="conception_option" id="marketing_sociaux_conception" value="marketing_sociaux_conception" data-price="2500">
                            <label class="form-check-label" for="marketing_sociaux_conception">
                                Marketing des Médias Sociaux <span class="text-secondary">2500 MAD</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Configuration de CRMs -->
                    <div class="form-check mb-2">
                        <input class="form-check-input category-checkbox" type="checkbox" id="crm" name="services[]" value="crm" data-category="crm">
                        <label class="form-check-label" for="crm">
                            Configuration de CRMs
                        </label>
                    </div>
                    
                    <!-- Options pour Configuration de CRMs -->
                    <div class="service-options" id="crm_options" style="display: none;">
                        <div class="form-check">
                            <input class="form-check-input service-radio" type="radio" name="crm_option" id="crm_essentiel" value="crm_essentiel" data-price="3000">
                            <label class="form-check-label" for="crm_essentiel">
                                Configuration de CRM Essentiel <span class="text-secondary">3000 MAD</span>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input service-radio" type="radio" name="crm_option" id="crm_premium" value="crm_premium" data-price="6000">
                            <label class="form-check-label" for="crm_premium">
                                Configuration de CRM Premium <span class="text-secondary">6000 MAD</span>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input service-radio" type="radio" name="crm_option" id="crm_avancee" value="crm_avancee" data-price="9000">
                            <label class="form-check-label" for="crm_avancee">
                                Configuration de CRM Avancée <span class="text-secondary">9000 MAD</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Total -->
            <div class="row mb-4">
                <div class="col-md-12 text-end">
                    <label class="form-label me-2">Total :</label>
                    <input type="text" class="form-control d-inline-block" id="total" name="total" readonly style="width: 120px; text-align: right;" value="0 MAD">
                    <input type="hidden" id="total_price" name="total_price" value="0">
                </div>
            </div>
            
            <!-- Bouton de validation -->
            <div class="row">
                <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-success">Valider</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Afficher/masquer les options pour chaque catégorie
            const categoryCheckboxes = document.querySelectorAll('.category-checkbox');
            
            categoryCheckboxes.forEach(function(checkbox) {
                const categoryId = checkbox.getAttribute('data-category');
                if (categoryId) {
                    const optionsDiv = document.getElementById(categoryId + '_options');
                    
                    if (optionsDiv) {
                        checkbox.addEventListener('change', function() {
                            optionsDiv.style.display = this.checked ? 'block' : 'none';
                            calculateTotal();
                        });
                    }
                }
            });
            
            // Calcul du total
            function calculateTotal() {
                let total = 0;
                
                // Parcourir toutes les catégories cochées
                categoryCheckboxes.forEach(function(checkbox) {
                    if (checkbox.checked) {
                        const categoryId = checkbox.getAttribute('data-category');
                        if (categoryId) {
                            // Trouver l'option radio sélectionnée dans cette catégorie
                            const selectedOption = document.querySelector(`input[name="${categoryId}_option"]:checked`);
                            if (selectedOption) {
                                total += parseInt(selectedOption.dataset.price);
                            }
                        }
                    }
                });
                
                // Mettre à jour les champs
                document.getElementById('total').value = total + ' MAD';
                document.getElementById('total_price').value = total;
            }
            
            // Écouter les changements dans tous les champs qui affectent le total
            const serviceRadios = document.querySelectorAll('.service-radio');
            serviceRadios.forEach(function(radio) {
                radio.addEventListener('change', calculateTotal);
            });
            
            // Initialiser le total
            calculateTotal();
        });
    </script>
</x-app-layout> 