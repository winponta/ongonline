namespace NExportRawToISOTextDotNET
{
   partial class Form1
   {
      /// <summary>
      /// Required designer variable.
      /// </summary>
      private System.ComponentModel.IContainer components = null;

      /// <summary>
      /// Clean up any resources being used.
      /// </summary>
      /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
      protected override void Dispose(bool disposing)
      {
         if (disposing && (components != null))
         {
            components.Dispose();
         }
         base.Dispose(disposing);
      }

      #region Windows Form Designer generated code

      /// <summary>
      /// Required method for Designer support - do not modify
      /// the contents of this method with the code editor.
      /// </summary>
      private void InitializeComponent()
      {
         this.listRet = new System.Windows.Forms.ListBox();
         this.ISO2Check = new System.Windows.Forms.Button();
         this.ISOV2WSQ = new System.Windows.Forms.Button();
         this.ISOV2 = new System.Windows.Forms.Button();
         this.ISOV1WSQ = new System.Windows.Forms.Button();
         this.ISOV1 = new System.Windows.Forms.Button();
         this.SuspendLayout();
         // 
         // listRet
         // 
         this.listRet.FormattingEnabled = true;
         this.listRet.Location = new System.Drawing.Point(274, 12);
         this.listRet.Name = "listRet";
         this.listRet.Size = new System.Drawing.Size(321, 290);
         this.listRet.TabIndex = 11;
         // 
         // ISO2Check
         // 
         this.ISO2Check.Location = new System.Drawing.Point(12, 244);
         this.ISO2Check.Name = "ISO2Check";
         this.ISO2Check.Size = new System.Drawing.Size(255, 52);
         this.ISO2Check.TabIndex = 10;
         this.ISO2Check.Text = "ISO 19794-2 Data Check";
         this.ISO2Check.UseVisualStyleBackColor = true;
         this.ISO2Check.Click += new System.EventHandler(this.ISO2Check_Click);
         // 
         // ISOV2WSQ
         // 
         this.ISOV2WSQ.Location = new System.Drawing.Point(12, 186);
         this.ISOV2WSQ.Name = "ISOV2WSQ";
         this.ISOV2WSQ.Size = new System.Drawing.Size(255, 52);
         this.ISOV2WSQ.TabIndex = 9;
         this.ISOV2WSQ.Text = "Raw to ISO with V2";
         this.ISOV2WSQ.UseVisualStyleBackColor = true;
         this.ISOV2WSQ.Click += new System.EventHandler(this.ISOV2WSQ_Click);
         // 
         // ISOV2
         // 
         this.ISOV2.Location = new System.Drawing.Point(12, 128);
         this.ISOV2.Name = "ISOV2";
         this.ISOV2.Size = new System.Drawing.Size(255, 52);
         this.ISOV2.TabIndex = 8;
         this.ISOV2.Text = "Raw to ISO V2";
         this.ISOV2.UseVisualStyleBackColor = true;
         this.ISOV2.Click += new System.EventHandler(this.ISOV2_Click);
         // 
         // ISOV1WSQ
         // 
         this.ISOV1WSQ.Location = new System.Drawing.Point(12, 70);
         this.ISOV1WSQ.Name = "ISOV1WSQ";
         this.ISOV1WSQ.Size = new System.Drawing.Size(255, 52);
         this.ISOV1WSQ.TabIndex = 7;
         this.ISOV1WSQ.Text = "Raw to ISO with WSQ V1";
         this.ISOV1WSQ.UseVisualStyleBackColor = true;
         this.ISOV1WSQ.Click += new System.EventHandler(this.ISOV1WSQ_Click);
         // 
         // ISOV1
         // 
         this.ISOV1.Location = new System.Drawing.Point(12, 12);
         this.ISOV1.Name = "ISOV1";
         this.ISOV1.Size = new System.Drawing.Size(255, 52);
         this.ISOV1.TabIndex = 6;
         this.ISOV1.Text = "Raw to ISO V1";
         this.ISOV1.UseVisualStyleBackColor = true;
         this.ISOV1.Click += new System.EventHandler(this.ISOV1_Click);
         // 
         // Form1
         // 
         this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
         this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
         this.ClientSize = new System.Drawing.Size(606, 311);
         this.Controls.Add(this.listRet);
         this.Controls.Add(this.ISO2Check);
         this.Controls.Add(this.ISOV2WSQ);
         this.Controls.Add(this.ISOV2);
         this.Controls.Add(this.ISOV1WSQ);
         this.Controls.Add(this.ISOV1);
         this.Name = "Form1";
         this.Text = "Form1";
         this.ResumeLayout(false);

      }

      #endregion

      private System.Windows.Forms.ListBox listRet;
      private System.Windows.Forms.Button ISO2Check;
      private System.Windows.Forms.Button ISOV2WSQ;
      private System.Windows.Forms.Button ISOV2;
      private System.Windows.Forms.Button ISOV1WSQ;
      private System.Windows.Forms.Button ISOV1;
   }
}

