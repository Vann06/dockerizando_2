<template>
    <div class="faq-container">
      <div class="faq-header">
        <h1>¿Necesitas ayuda?</h1>
        <p class="subtitle">Estamos aquí para ayudarte...</p>
      </div>
  
      <div class="faq-content">
        <div class="faq-sidebar">
          <div class="help-section">
            <h3>TEMAS DE AYUDA</h3>
            <ul>
              <li @click="setActiveSection('orders')" :class="{active: activeSection === 'orders'}">Pedidos</li>
              <li @click="setActiveSection('products')" :class="{active: activeSection === 'products'}">Productos</li>
              <li @click="setActiveSection('shipping')" :class="{active: activeSection === 'shipping'}">Envíos</li>
              <li @click="setActiveSection('returns')" :class="{active: activeSection === 'returns'}">Devoluciones</li>
              <li @click="setActiveSection('quotations')" :class="{active: activeSection === 'quotations'}">Cotizaciones</li>
              <li @click="setActiveSection('technical')" :class="{active: activeSection === 'technical'}">Soporte Técnico</li>
            </ul>
          </div>
  
          <div class="contact-promo">
            <h3>¿AÚN NECESITAS AYUDA?</h3>
            <p>Contáctanos directamente:</p>
            <button class="contact-button">CONTÁCTANOS AQUÍ</button>
          </div>
        </div>
  
        <div class="faq-main">
          <!-- Barra de búsqueda en el lado derecho -->
          <div class="search-container right-search">
            <input 
              type="text" 
              v-model="searchQuery" 
              placeholder="Buscar en todas las preguntas..." 
              @input="handleSearch"
              class="search-input"
            >
            <span class="search-icon">🔍</span>
          </div>
  
          <!-- Mostrar resultados de búsqueda global -->
          <div v-if="searchQuery" class="search-results-container">
            <div v-if="filteredResults.length > 0">
              <h2>Resultados de búsqueda para "{{searchQuery}}"</h2>
              <div 
                class="faq-item" 
                v-for="(result, index) in filteredResults" 
                :key="'result-'+index"
              >
                <div class="faq-question" @click="navigateToResult(result)">
                  <span class="section-badge">{{getSectionName(result.section)}}</span>
                  <span>{{result.question}}</span>
                  <span class="icon">+</span>
                </div>
              </div>
            </div>
            <div v-else class="no-results">
              No se encontraron resultados para "{{searchQuery}}"
            </div>
          </div>
  
          <!-- Mostrar contenido normal cuando no hay búsqueda -->
          <template v-else>
            <!-- Sección de Pedidos -->
            <div v-if="activeSection === 'orders'" class="faq-section">
              <h2>PEDIDOS</h2>
              <div 
                class="faq-item" 
                v-for="(item, index) in orderFaqs" 
                :key="'order-'+index"
              >
                <div class="faq-question" @click="toggleFAQ('order', index)">
                  <span>{{item.question}}</span>
                  <span class="icon">{{activeAnswers.order[index] ? '−' : '+'}}</span>
                </div>
                <transition name="slide">
                  <div class="faq-answer" v-show="activeAnswers.order[index]">
                    <p>{{item.answer}}</p>
                  </div>
                </transition>
              </div>
            </div>
  
            <!-- Sección de Productos -->
            <div v-if="activeSection === 'products'" class="faq-section">
              <h2>PRODUCTOS</h2>
              <div 
                class="faq-item" 
                v-for="(item, index) in productFaqs" 
                :key="'product-'+index"
              >
                <div class="faq-question" @click="toggleFAQ('product', index)">
                  <span>{{item.question}}</span>
                  <span class="icon">{{activeAnswers.product[index] ? '−' : '+'}}</span>
                </div>
                <transition name="slide">
                  <div class="faq-answer" v-show="activeAnswers.product[index]">
                    <p>{{item.answer}}</p>
                  </div>
                </transition>
              </div>
            </div>
  
            <!-- Sección de Envíos -->
            <div v-if="activeSection === 'shipping'" class="faq-section">
              <h2>ENVÍOS</h2>
              <div 
                class="faq-item" 
                v-for="(item, index) in shippingFaqs" 
                :key="'shipping-'+index"
              >
                <div class="faq-question" @click="toggleFAQ('shipping', index)">
                  <span>{{item.question}}</span>
                  <span class="icon">{{activeAnswers.shipping[index] ? '−' : '+'}}</span>
                </div>
                <transition name="slide">
                  <div class="faq-answer" v-show="activeAnswers.shipping[index]">
                    <p>{{item.answer}}</p>
                  </div>
                </transition>
              </div>
            </div>
  
            <!-- Sección de Devoluciones -->
            <div v-if="activeSection === 'returns'" class="faq-section">
              <h2>DEVOLUCIONES</h2>
              <div 
                class="faq-item" 
                v-for="(item, index) in returnFaqs" 
                :key="'return-'+index"
              >
                <div class="faq-question" @click="toggleFAQ('return', index)">
                  <span>{{item.question}}</span>
                  <span class="icon">{{activeAnswers.return[index] ? '−' : '+'}}</span>
                </div>
                <transition name="slide">
                  <div class="faq-answer" v-show="activeAnswers.return[index]">
                    <p>{{item.answer}}</p>
                  </div>
                </transition>
              </div>
            </div>
  
            <!-- Sección de Cotizaciones -->
            <div v-if="activeSection === 'quotations'" class="faq-section">
              <h2>COTIZACIONES</h2>
              <div 
                class="faq-item" 
                v-for="(item, index) in quotationFaqs" 
                :key="'quotation-'+index"
              >
                <div class="faq-question" @click="toggleFAQ('quotation', index)">
                  <span>{{item.question}}</span>
                  <span class="icon">{{activeAnswers.quotation[index] ? '−' : '+'}}</span>
                </div>
                <transition name="slide">
                  <div class="faq-answer" v-show="activeAnswers.quotation[index]">
                    <p>{{item.answer}}</p>
                  </div>
                </transition>
              </div>
            </div>
  
            <!-- Sección de Soporte Técnico -->
            <div v-if="activeSection === 'technical'" class="faq-section">
              <h2>SOPORTE TÉCNICO</h2>
              <div 
                class="faq-item" 
                v-for="(item, index) in technicalFaqs" 
                :key="'technical-'+index"
              >
                <div class="faq-question" @click="toggleFAQ('technical', index)">
                  <span>{{item.question}}</span>
                  <span class="icon">{{activeAnswers.technical[index] ? '−' : '+'}}</span>
                </div>
                <transition name="slide">
                  <div class="faq-answer" v-show="activeAnswers.technical[index]">
                    <p>{{item.answer}}</p>
                  </div>
                </transition>
              </div>
            </div>
          </template>
        </div>
      </div>
  
      <div class="policies-section">
        <h3>POLÍTICAS</h3>
        <div class="policies-grid">
          <div class="policy-item">Política de Devoluciones Online</div>
          <div class="policy-item">Política de Devoluciones en Tienda</div>
          <div class="policy-item">Política de Envíos</div>
          <div class="policy-item">Política de Privacidad</div>
          <div class="policy-item">Términos de Servicio</div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'FAQComponent',
    data() {
      return {
        searchQuery: '',
        activeSection: 'orders',
        activeAnswers: {
          order: [],
          product: [],
          shipping: [],
          return: [],
          quotation: [],
          technical: []
        },
        lastOpened: {
          section: null,
          index: null
        },
        orderFaqs: [
          {
            question: "¿Cómo puedo realizar un seguimiento de mi pedido?",
            answer: "Puedes rastrear tu pedido ingresando a 'Mis Pedidos' en tu cuenta o usando el enlace de seguimiento que te enviamos por correo electrónico."
          },
          {
            question: "¿Cómo cambio o cancelo mi pedido?",
            answer: "Los pedidos pueden cancelarse dentro de las primeras 2 horas después de realizado. Para cambios, contáctanos inmediatamente a través de nuestro chat de soporte."
          },
          {
            question: "¿Qué métodos de pago aceptan?",
            answer: "Aceptamos tarjetas de crédito/débito, PayPal, transferencias bancarias y pagos en efectivo contra entrega en algunas zonas."
          }
        ],
        productFaqs: [
          {
            question: "¿Cómo sé qué talla debo comprar?",
            answer: "Cada producto tiene una guía de tallas en su página de descripción. También ofrecemos asesoramiento gratuito por chat para ayudarte a elegir la talla correcta."
          },
          {
            question: "¿Los colores de los productos son exactos a los mostrados?",
            answer: "Hacemos todo lo posible por mostrar los colores con precisión, pero pueden variar ligeramente dependiendo de la configuración de tu pantalla."
          }
        ],
        shippingFaqs: [
          {
            question: "¿Cuánto tarda el envío de mi pedido?",
            answer: "El tiempo de envío varía entre 2-5 días hábiles para áreas urbanas y hasta 7 días hábiles para zonas rurales. Los tiempos pueden extenderse en temporadas altas."
          },
          {
            question: "¿Hacen envíos internacionales?",
            answer: "Sí, realizamos envíos a la mayoría de países. Los costos y tiempos de envío varían según el destino."
          }
        ],
        returnFaqs: [
          {
            question: "¿Cuál es la política de devoluciones?",
            answer: "Aceptamos devoluciones dentro de los 15 días posteriores a la recepción del pedido. Los productos deben estar en su estado original con etiquetas."
          },
          {
            question: "¿Cómo puedo devolver un producto?",
            answer: "Puedes iniciar una devolución desde 'Mis Pedidos' en tu cuenta o contactando a nuestro servicio al cliente. Te enviaremos una etiqueta de devolución."
          }
        ],
        quotationFaqs: [
          {
            question: "¿Cómo solicito una cotización para compras al por mayor?",
            answer: "Puedes solicitar una cotización completando el formulario en nuestra sección 'Cotizaciones' o contactando directamente a nuestro equipo de ventas corporativas a ventas@tienda.com."
          },
          {
            question: "¿Ofrecen descuentos por volumen?",
            answer: "Sí, ofrecemos descuentos escalonados para pedidos al por mayor. El porcentaje de descuento depende de la cantidad de productos solicitados."
          },
          {
            question: "¿Cuánto tarda el proceso de cotización?",
            answer: "Nuestro equipo responde a las solicitudes de cotización dentro de las 24 horas hábiles posteriores a la recepción de tu consulta."
          }
        ],
        technicalFaqs: [
          {
            question: "No puedo iniciar sesión en mi cuenta, ¿qué debo hacer?",
            answer: "Puedes restablecer tu contraseña usando la opción 'Olvidé mi contraseña'. Si el problema persiste, contáctanos para asistencia técnica."
          },
          {
            question: "El sitio web no funciona correctamente, ¿cómo lo reporto?",
            answer: "Por favor descríbenos el problema que estás experimentando a través de nuestro formulario de contacto técnico, incluyendo capturas de pantalla si es posible."
          }
        ]
      }
    },
    computed: {
      filteredResults() {
        if (!this.searchQuery) return [];
        
        const query = this.searchQuery.toLowerCase();
        const results = [];
        
        // Buscar en todas las secciones
        const sections = [
          { key: 'order', name: 'Pedidos', faqs: this.orderFaqs },
          { key: 'product', name: 'Productos', faqs: this.productFaqs },
          { key: 'shipping', name: 'Envíos', faqs: this.shippingFaqs },
          { key: 'return', name: 'Devoluciones', faqs: this.returnFaqs },
          { key: 'quotation', name: 'Cotizaciones', faqs: this.quotationFaqs },
          { key: 'technical', name: 'Soporte Técnico', faqs: this.technicalFaqs }
        ];
        
        sections.forEach(section => {
          section.faqs.forEach((item, index) => {
            if (item.question.toLowerCase().includes(query) || 
                item.answer.toLowerCase().includes(query)) {
              results.push({
                section: section.key,
                sectionName: section.name,
                question: item.question,
                answer: item.answer,
                index: index
              });
            }
          });
        });
        
        return results;
      }
    },
    methods: {
      getSectionName(sectionKey) {
        const names = {
          'order': 'Pedidos',
          'product': 'Productos',
          'shipping': 'Envíos',
          'return': 'Devoluciones',
          'quotation': 'Cotizaciones',
          'technical': 'Soporte Técnico'
        };
        return names[sectionKey] || sectionKey;
      },
      
      setActiveSection(section) {
        this.activeSection = section;
        this.closeAllAnswers();
      },
      
      toggleFAQ(section, index) {
        if (this.lastOpened.section && this.lastOpened.section === section && this.lastOpened.index !== null) {
          this.$set(this.activeAnswers[section], this.lastOpened.index, false);
        }
        
        const newState = !this.activeAnswers[section][index];
        this.$set(this.activeAnswers[section], index, newState);
        
        if (newState) {
          this.lastOpened = { section, index };
        } else {
          this.lastOpened = { section: null, index: null };
        }
      },
      
      navigateToResult(result) {
        this.setActiveSection(result.section + 's'); // Añadir 's' para coincidir con activeSection
        this.$nextTick(() => {
          this.toggleFAQ(result.section, result.index);
        });
      },
      
      closeAllAnswers() {
        Object.keys(this.activeAnswers).forEach(section => {
          this.activeAnswers[section] = this.activeAnswers[section].map(() => false);
        });
        this.lastOpened = { section: null, index: null };
      },
      
      initializeActiveAnswers() {
        Object.keys(this.activeAnswers).forEach(section => {
          this.activeAnswers[section] = Array(this[`${section}Faqs`].length).fill(false);
        });
      },
      
      handleSearch() {
        this.closeAllAnswers();
      }
    },
    created() {
      this.initializeActiveAnswers();
    }
  }
  </script>
  
  <style scoped>
  .faq-container {
    font-family: 'Montserrat', sans-serif;
    max-width: 1200px;
    margin: 0 auto;
    padding: 40px 20px;
    background-color: #FFFFFF;
  }
  
  .faq-header {
    text-align: center;
    margin-bottom: 50px;
    padding-bottom: 20px;
    border-bottom: 2px solid #780116;
  }
  
  .faq-header h1 {
    font-size: 2.5rem;
    color: #780116;
    margin-bottom: 15px;
    font-weight: 700;
  }
  
  .subtitle {
    font-size: 1.2rem;
    color: #6c757d;
  }
  
  .faq-content {
    display: flex;
    gap: 30px;
    background-color: #FFFFFF;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(120, 1, 22, 0.1);
  }
  
  .faq-sidebar {
    width: 280px;
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    gap: 25px;
  }
  
  .search-container {
    position: relative;
    margin-bottom: 25px;
  }
  
  .right-search {
    margin-left: auto;
    width: 100%;
    max-width: 400px;
  }
  
  .search-input {
    width: 100%;
    padding: 12px 20px 12px 45px;
    border: 2px solid #F7B538;
    border-radius: 30px;
    font-size: 0.95rem;
    outline: none;
    transition: all 0.3s;
    box-shadow: 0 2px 10px rgba(120, 1, 22, 0.1);
  }
  
  .search-input:focus {
    border-color: #780116;
    box-shadow: 0 4px 15px rgba(120, 1, 22, 0.2);
  }
  
  .search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: #780116;
    font-size: 1.1rem;
  }
  
  .help-section {
    background-color: #FFF9F0;
    padding: 25px;
    border-radius: 8px;
    border: 1px solid #F7B538;
  }
  
  .help-section h3 {
    color: #780116;
    font-size: 1.1rem;
    text-transform: uppercase;
    margin-bottom: 20px;
    letter-spacing: 1px;
  }
  
  .help-section ul {
    list-style: none;
    padding: 0;
    margin: 0;
  }
  
  .help-section li {
    padding: 12px 0;
    cursor: pointer;
    border-bottom: 1px solid #F7B538;
    transition: all 0.3s;
    font-size: 0.95rem;
  }
  
  .help-section li:hover {
    color: #780116;
    background-color: #FEF0D7;
  }
  
  .help-section li.active {
    color: #FFFFFF;
    background-color: #780116;
    font-weight: 600;
    padding-left: 15px;
  }
  
  .contact-promo {
    background-color: #780116;
    color: white;
    padding: 25px;
    border-radius: 8px;
    text-align: center;
    border: 1px solid #5A0113;
  }
  
  .contact-promo h3 {
    font-size: 1.1rem;
    text-transform: uppercase;
    margin-bottom: 15px;
    letter-spacing: 1px;
  }
  
  .contact-promo p {
    margin-bottom: 20px;
    font-size: 0.95rem;
  }
  
  .contact-button {
    background-color: #F7B538;
    color: #780116;
    border: none;
    padding: 12px 25px;
    font-weight: 600;
    border-radius: 6px;
    cursor: pointer;
    transition: all 0.3s;
    font-size: 0.95rem;
    box-shadow: 0 2px 10px rgba(247, 181, 56, 0.3);
  }
  
  .contact-button:hover {
    background-color: #F5A90E;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(247, 181, 56, 0.4);
  }
  
  .faq-main {
    flex-grow: 1;
  }
  
  .faq-section h2 {
    color: #780116;
    font-size: 1.8rem;
    margin-bottom: 25px;
    padding-bottom: 10px;
    border-bottom: 2px solid #F7B538;
  }
  
  .faq-item {
    margin-bottom: 20px;
    border: 1px solid #F7B538;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.3s;
  }
  
  .faq-item:hover {
    box-shadow: 0 4px 12px rgba(120, 1, 22, 0.1);
  }
  
  .faq-question {
    padding: 18px 25px;
    background-color: #FFF9F0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
    transition: all 0.3s;
  }
  
  .faq-question:hover {
    background-color: #FEF0D7;
  }
  
  .faq-question .icon {
    font-weight: bold;
    font-size: 1.3rem;
    color: #780116;
    transition: all 0.3s;
  }
  
  .faq-answer {
    padding: 25px;
    background-color: white;
    color: #495057;
    line-height: 1.7;
    border-left: 4px solid #780116;
  }
  
  .no-results {
    text-align: center;
    padding: 30px;
    color: #780116;
    font-style: italic;
  }
  
  .slide-enter-active, .slide-leave-active {
    transition: all 0.4s ease;
    max-height: 500px;
    overflow: hidden;
  }
  
  .slide-enter, .slide-leave-to {
    max-height: 0;
    opacity: 0;
    padding: 0 25px;
  }
  
  .policies-section {
    margin-top: 60px;
    padding-top: 40px;
    border-top: 2px solid #780116;
  }
  
  .policies-section h3 {
    color: #780116;
    font-size: 1.2rem;
    text-transform: uppercase;
    margin-bottom: 25px;
    letter-spacing: 1px;
    text-align: center;
  }
  
  .policies-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 20px;
  }
  
  .policy-item {
    padding: 20px;
    background-color: #FFF9F0;
    border-radius: 8px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s;
    border: 1px solid #F7B538;
    font-weight: 500;
  }
  
  .policy-item:hover {
    background-color: #780116;
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(120, 1, 22, 0.2);
  }
  
  @media (max-width: 992px) {
    .right-search {
      max-width: 100%;
      order: -1;
      margin-bottom: 20px;
      margin-left: 0;
    }
    
    .faq-content {
      flex-direction: column;
    }
    
    .faq-sidebar {
      width: 100%;
      margin-bottom: 30px;
    }
  }
  
  @media (max-width: 768px) {
    .faq-header h1 {
      font-size: 2.2rem;
    }
    
    .faq-section h2 {
      font-size: 1.6rem;
    }
  
    .right-search {
      margin: 0 auto 20px;
    }
  }
  
  @media (max-width: 576px) {
    .policies-grid {
      grid-template-columns: 1fr;
    }
    
    .faq-header h1 {
      font-size: 2rem;
    }
    
    .faq-content {
      padding: 20px;
    }
    
    .help-section, .contact-promo {
      padding: 20px;
    }
  }
  </style>
  